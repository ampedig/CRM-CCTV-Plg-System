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

    public function create(): View
    {
        return view('dashboard.customers.create');
    }

    public function store(Request $request)
    {
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

    public function edit(Customer $customer): View
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20|unique:customers,whatsapp_number,'.$customer->id,
            'occupation' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
