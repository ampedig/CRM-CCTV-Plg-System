@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex-1 p-4">
        <div class="max-w-screen-2xl mx-auto">

            <!-- Menu 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Pelanggan -->
                <a href="{{ route('customers.index') }}"
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-users text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Pelanggan
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            {{ $totalCustomers }}</h3>
                    </div>
                </a>

                <!-- Total Transaksi -->
                <a href="{{ route('transactions.index') }}"
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-receipt text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Transaksi
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            {{ $totalTransactions }}</h3>
                    </div>
                </a>

                <!-- Total Produk -->
                <a href="{{ route('products.index') }}"
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-box text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Produk
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            {{ $totalProducts }}</h3>
                    </div>
                </a>

                <!-- Total Pegawai -->
                <a href="{{ route('users.index') }}"
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-user-tie text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Pegawai
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            {{ $totalEmployees }}</h3>
                    </div>
                </a>
            </div>

            <!-- LAYOUT GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">

                <!-- Chart (ApexCharts) -->
                <div class="lg:col-span-3 bg-white border border-slate-200 rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="t-title text-base font-semibold text-slate-900">Grafik Penjualan</h3>
                        <div class="flex gap-2">
                            <button
                                class="px-3 py-1 text-xs font-semibold text-brand-600 bg-brand-50 rounded-lg transition-colors hover:bg-brand-100">
                                Income
                            </button>
                            <button
                                class="px-3 py-1 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">
                                Expense
                            </button>
                        </div>
                    </div>
                    <div id="revenueChart" class="w-full"></div>
                </div>

                <!-- Chart (ECharts) -->
                <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6">
                    <h3 class="t-title text-base font-semibold text-slate-900 mb-6">Pengunjung per Perangkat
                    </h3>
                    <div id="userChart" class="w-full h-[350px]"></div>
                </div>
            </div>

            <!-- TABLE SECTION -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <h3 class="t-title font-semibold text-slate-900">Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    ID</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Pelanggan</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Total Belanja</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Status</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($latestTransactions as $transaction)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">#TRX-{{ $transaction->id }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 td-nowrap">
                                        {{ $transaction->created_at->translatedFormat('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $transaction->customer->full_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        @if ($transaction->payment_status === 'paid')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700">Paid</span>
                                        @elseif ($transaction->payment_status === 'pending')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                        @elseif ($transaction->payment_status === 'canceled')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700">Canceled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                                class="btn btn-secondary btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada transaksi terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/libs/echarts/echarts.min.js"></script>
    <script src="assets/js/dashboard.page.js"></script>
@endsection
