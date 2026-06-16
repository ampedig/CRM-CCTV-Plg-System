<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('whatsapp_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('dashboard.customers.index', compact('customers', 'search'));
    }

    /**
     * Export customers to Excel (.xlsx format).
     */
    public function export(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $search = $request->input('search');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                    ->orWhere('whatsapp_number', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CustomersExport($customers),
            'pelanggan-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }

    public function create(): View
    {
        return view('dashboard.customers.create');
    }

    public function store(Request $request)
    {
        if ($request->filled('whatsapp_number')) {
            $request->merge([
                'whatsapp_number' => $this->formatWhatsAppNumber($request->input('whatsapp_number'))
            ]);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20|unique:customers,whatsapp_number',
            'occupation' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function show(Customer $customer): View
    {
        $transactions = $customer->transactions()
            ->latest()
            ->paginate(10);

        return view('dashboard.customers.show', compact('customer', 'transactions'));
    }

    public function edit(Customer $customer): View
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if ($request->filled('whatsapp_number')) {
            $request->merge([
                'whatsapp_number' => $this->formatWhatsAppNumber($request->input('whatsapp_number'))
            ]);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20|unique:customers,whatsapp_number,'.$customer->id,
            'occupation' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
            'total_chats_received' => 'required|integer|min:0',
            'consultation_frequency' => 'required|integer|min:0',
            'web_visit_count' => 'required|integer|min:0',
            'transaction_count' => 'required|integer|min:0',
            'total_transaction_value' => 'required|numeric|min:0',
            'last_product_interest' => 'nullable|string|max:255',
            'lead_score_status' => 'required|string|in:Cold,Warm,Hot,cold,warm,hot',
            'payment_status' => 'required|string|in:Belum,Lunas',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }

    /**
     * Normalize WhatsApp number to format: 628...
     */
    private function formatWhatsAppNumber(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }
}
