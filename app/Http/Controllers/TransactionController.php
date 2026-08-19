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
     * Export transactions to Excel (.xlsx format).
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

        $export   = new \App\Exports\TransactionsExport($transactions);
        $filename = 'transaksi-' . now()->format('Y-m-d-His') . '.xlsx';

        return (new \Rap2hpoutre\FastExcel\FastExcel($export->collection()))->download($filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::where('is_active', 1)->orderBy('id', 'desc')->get();
        $products = Product::with('category')->where('is_active', 1)->get();

        return view('dashboard.transactions.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'transaction_date' => 'required|date',
            'payment_status' => 'required|in:pending,paid,canceled',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $transaction = Transaction::create([
                'customer_id' => $validated['customer_id'],
                'transaction_date' => $validated['transaction_date'],
                'payment_status' => $validated['payment_status'],
                'grand_total' => 0, // Temporary grand total
            ]);

            $grandTotal = 0;
            $lastProductInterest = null;

            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::with('category')->findOrFail($productId);
                $qty = intval($validated['quantity'][$index]);
                $subTotal = $product->price * $qty;
                $grandTotal += $subTotal;

                $transaction->details()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'sub_total' => $subTotal,
                ]);

                if ($lastProductInterest === null) {
                    $lastProductInterest = $product->category ? $product->category->name : $product->name;
                }
            }

            $transaction->update([
                'grand_total' => $grandTotal,
            ]);

            if ($lastProductInterest) {
                $transaction->customer->update([
                    'last_product_interest' => $lastProductInterest
                ]);
            }
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
        $customers = Customer::where('is_active', 1)->orderBy('id', 'desc')->get();
        $products = Product::with('category')->where('is_active', 1)->get();

        return view('dashboard.transactions.edit', compact('transaction', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'transaction_date' => 'required|date',
            'payment_status' => 'required|in:pending,paid,canceled',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $transaction) {
            $transaction->update([
                'customer_id' => $validated['customer_id'],
                'transaction_date' => $validated['transaction_date'],
                'payment_status' => $validated['payment_status'],
            ]);

            // Clear old details
            $transaction->details()->delete();

            $grandTotal = 0;
            $lastProductInterest = null;

            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::with('category')->findOrFail($productId);
                $qty = intval($validated['quantity'][$index]);
                $subTotal = $product->price * $qty;
                $grandTotal += $subTotal;

                $transaction->details()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'sub_total' => $subTotal,
                ]);

                if ($lastProductInterest === null) {
                    $lastProductInterest = $product->category ? $product->category->name : $product->name;
                }
            }

            $transaction->update([
                'grand_total' => $grandTotal,
            ]);

            if ($lastProductInterest) {
                $transaction->customer->update([
                    'last_product_interest' => $lastProductInterest
                ]);
            }
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
