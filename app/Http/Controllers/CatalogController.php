<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

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

        $products = $query->paginate(2)->withQueryString();

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
}
