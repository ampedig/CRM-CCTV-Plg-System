<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $latestTransactions = Transaction::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        $totalCustomers = Customer::count();
        $totalTransactions = Transaction::count();
        $totalProducts = Product::count();
        $totalEmployees = User::count();

        return view('dashboard.dashboard', compact(
            'latestTransactions',
            'totalCustomers',
            'totalTransactions',
            'totalProducts',
            'totalEmployees'
        ));
    }
}
