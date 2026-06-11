<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->where('is_active', true)->get();

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
