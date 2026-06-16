<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $transactions = Transaction::query()
            ->with(['customer'])
            ->when($search, function ($query, $search) {
                $query->where('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('dashboard.transactions.index', compact('transactions', 'search'));
    }

    /**
     * Export transactions to Excel (CSV format).
     */
    public function export(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $search = $request->input('search');

        $transactions = Transaction::query()
            ->with(['customer', 'details.product'])
            ->when($search, function ($query, $search) {
                $query->where('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->get();

        $filename = 'transaksi-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to ensure proper character encoding in Microsoft Excel
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'ID Transaksi',
                'Tanggal',
                'Nama Pelanggan',
                'Detail Produk',
                'Total Transaksi (Rp)',
                'Status Pembayaran'
            ]);

            foreach ($transactions as $transaction) {
                $detailsArray = [];
                foreach ($transaction->details as $detail) {
                    $productName = $detail->product?->name ?? 'Produk Terhapus';
                    $detailsArray[] = "{$productName} ({$detail->quantity}x)";
                }
                $detailsText = implode(', ', $detailsArray);

                fputcsv($file, [
                    $transaction->id,
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->customer?->full_name ?? '-',
                    $detailsText,
                    number_format($transaction->grand_total, 2, ',', '.'),
                    ucfirst($transaction->payment_status)
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)->get();

        return view('dashboard.transactions.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_status' => 'required|in:pending,paid,canceled',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $transaction = Transaction::create([
                'customer_id' => $validated['customer_id'],
                'payment_status' => $validated['payment_status'],
                'grand_total' => 0, // Temporary grand total
            ]);

            $grandTotal = 0;

            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::findOrFail($productId);
                $qty = intval($validated['quantity'][$index]);
                $subTotal = $product->price * $qty;
                $grandTotal += $subTotal;

                $transaction->details()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'sub_total' => $subTotal,
                ]);
            }

            $transaction->update([
                'grand_total' => $grandTotal,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): View
    {
        $transaction->load(['customer', 'details.product']);
        return view('dashboard.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): View
    {
        $transaction->load('details.product');
        $customers = Customer::where('is_active', 1)->get();
        $products = Product::where('is_active', 1)->get();

        return view('dashboard.transactions.edit', compact('transaction', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_status' => 'required|in:pending,paid,canceled',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $transaction) {
            $transaction->update([
                'customer_id' => $validated['customer_id'],
                'payment_status' => $validated['payment_status'],
            ]);

            // Clear old details
            $transaction->details()->delete();

            $grandTotal = 0;

            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::findOrFail($productId);
                $qty = intval($validated['quantity'][$index]);
                $subTotal = $product->price * $qty;
                $grandTotal += $subTotal;

                $transaction->details()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'sub_total' => $subTotal,
                ]);
            }

            $transaction->update([
                'grand_total' => $grandTotal,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
