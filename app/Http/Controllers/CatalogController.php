<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $query = Product::with('category')->where('is_active', true);

        // Search Filter
        if (request()->filled('search')) {
            $search = request()->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('merk', 'like', '%'.$search.'%')
                    ->orWhereHas('category', function ($catQuery) use ($search) {
                        $catQuery->where('name', 'like', '%'.$search.'%');
                    });
            });
        }

        // Category Filter
        if (request()->filled('category')) {
            $categorySlug = request()->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $query->orderBy('id', 'desc');

        $products = $query->paginate(20)->withQueryString();

        return view('catalog.index', compact('categories', 'products'));
    }

    public function detail(string $slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('catalog.detail', compact('product'));
    }

    public function cart()
    {
        return view('catalog.cart');
    }

    /**
     * Check if a customer exists by their WhatsApp number.
     */
    public function checkCustomer(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
        ]);

        $formattedNumber = $this->formatWhatsAppNumber($request->input('whatsapp_number'));
        $customer = Customer::where('whatsapp_number', $formattedNumber)->first();

        return response()->json([
            'exists' => $customer !== null,
            'whatsapp_number' => $formattedNumber,
            'customer' => $customer,
        ]);
    }

    /**
     * Register a new customer via public catalog modal.
     */
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
            'full_name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $formattedNumber = $this->formatWhatsAppNumber($request->input('whatsapp_number'));
        $customer = Customer::where('whatsapp_number', $formattedNumber)->first();

        if (! $customer) {
            $customer = Customer::create([
                'whatsapp_number' => $formattedNumber,
                'full_name' => $request->input('full_name'),
                'occupation' => $request->input('occupation'),
                'date_of_birth' => $request->input('date_of_birth'),
                'web_visit_count' => 1,
                'is_active' => 1,
            ]);
        } else {
            $customer->increment('web_visit_count');
        }

        return response()->json([
            'success' => true,
            'whatsapp_number' => $formattedNumber,
            'customer' => $customer,
        ]);
    }

    /**
     * Increment the customer's web visit count.
     */
    public function recordVisit(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
        ]);

        $formattedNumber = $this->formatWhatsAppNumber($request->input('whatsapp_number'));
        $customer = Customer::where('whatsapp_number', $formattedNumber)->first();

        if ($customer) {
            $customer->increment('web_visit_count');
            return response()->json([
                'success' => true,
                'web_visit_count' => $customer->web_visit_count,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Customer not found.',
        ], 404);
    }

    /**
     * Record customer's product interest (category name).
     */
    public function recordInterest(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
            'category_name' => 'required|string|max:255',
        ]);

        $formattedNumber = $this->formatWhatsAppNumber($request->input('whatsapp_number'));
        $customer = Customer::where('whatsapp_number', $formattedNumber)->first();

        if ($customer) {
            $customer->update([
                'last_product_interest' => $request->input('category_name'),
            ]);
            return response()->json([
                'success' => true,
                'last_product_interest' => $customer->last_product_interest,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Customer not found.',
        ], 404);
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
