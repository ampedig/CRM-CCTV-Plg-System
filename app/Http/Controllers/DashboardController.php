<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $latestTransactions = Transaction::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact('latestTransactions'));
    }
}
