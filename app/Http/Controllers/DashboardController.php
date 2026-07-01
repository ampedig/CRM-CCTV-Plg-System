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

        // Ambil data penjualan 7 hari terakhir secara dinamis
        $chartLabels = [];
        $chartIncome = [];
        $chartPending = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D'); // Contoh: Sen, Sel, Rab...

            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();

            // Total Income (Transaksi Lunas / paid)
            $income = Transaction::where('payment_status', 'paid')
                ->whereBetween('created_at', [$start, $end])
                ->sum('grand_total');

            // Total Pending (Transaksi belum lunas / pending)
            $pending = Transaction::where('payment_status', 'pending')
                ->whereBetween('created_at', [$start, $end])
                ->sum('grand_total');

            $chartIncome[] = (float) $income;
            $chartPending[] = (float) $pending;
        }

        // Ambil kategori produk paling banyak diminati (berdasarkan qty terjual)
        $popularCategories = \Illuminate\Support\Facades\DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as name', \Illuminate\Support\Facades\DB::raw('SUM(transaction_details.quantity) as value'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('value')
            ->limit(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'latestTransactions',
            'totalCustomers',
            'totalTransactions',
            'totalProducts',
            'totalEmployees',
            'chartLabels',
            'chartIncome',
            'chartPending',
            'popularCategories'
        ));
    }
}
