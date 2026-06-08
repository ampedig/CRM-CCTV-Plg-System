@extends('dashboard.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex-1 p-4">
        <div class="max-w-screen-2xl mx-auto">

            <!-- Menu 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-store text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Merchant
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            37</h3>
                    </div>
                </div>

                <a href="pengguna.html"
                    class="p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-users text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Total Pengguna
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            7</h3>
                    </div>
                </a>

                <div
                    class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                    <div
                        class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                        Hari Ini
                    </div>
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-money-bill-wave  text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Disbursement
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            17</h3>
                    </div>
                </div>

                <div
                    class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                    <div
                        class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                        Hari Ini
                    </div>
                    <div
                        class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-money-bill-wave  text-3xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                            Transaksi
                        </p>
                        <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                            75</h3>
                    </div>
                </div>
            </div>

            <!-- Menu 2 -->
            <div class="mb-8 mt-[-10px]">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                        <div
                            class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                            Hari Ini
                        </div>
                        <div
                            class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-clipboard-list text-3xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                                Transaksi Sukses
                            </p>
                            <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                                21</h3>
                        </div>
                    </div>

                    <div
                        class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                        <div
                            class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                            Hari Ini
                        </div>
                        <div
                            class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-chart-line text-3xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                                Pendapatan
                            </p>
                            <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                                Rp 1.750.000</h3>
                        </div>
                    </div>



                    <!-- Daily New Customers -->
                    <div
                        class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                        <div
                            class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                            Hari Ini
                        </div>
                        <div
                            class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-user-plus text-3xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                                Kosong
                            </p>
                            <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                                15</h3>
                        </div>
                    </div>

                    <!-- Daily Net Profit -->
                    <div
                        class="relative p-6 bg-white border border-slate-200 rounded-2xl flex items-center gap-4 hover:border-brand-500 transition-all duration-300 cursor-pointer group overflow-hidden">
                        <div
                            class="absolute top-0 right-0 px-3 py-1 bg-brand-50 text-brand-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl group-hover:bg-brand-600 group-hover:text-white transition-colors">
                            Hari Ini
                        </div>
                        <div
                            class="w-16 h-16 shrink-0 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid fa-coins text-3xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-brand-500/80 uppercase tracking-wider mb-1">
                                Kosong
                            </p>
                            <h3 class="t-h1 font-bold text-slate-800 truncate group-hover:text-brand-700 transition-colors">
                                Rp 250.000</h3>
                        </div>
                    </div>
                </div>
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
                    <h3 class="t-title font-semibold text-slate-900">Data Merchant</h3>
                    <a href="merchant.html" class="btn btn-primary btn-sm">Lihat Semua</a>
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
                                    Nama</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Pemilik</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Saldo</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Status</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <!-- Row 1 -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">#M-001</td>
                                <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Toko Berkah Utama</td>
                                <td class="px-6 py-4 text-slate-700 td-nowrap">Budi Santoso</td>
                                <td class="px-6 py-4 font-medium text-slate-700 td-nowrap">Rp 1.500.000</td>
                                <td class="px-6 py-4 td-nowrap">
                                    <span
                                        class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-center td-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="show-merchant.html"
                                            class="btn btn-secondary btn-sm flex items-center gap-2">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Row 2 -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">#M-002</td>
                                <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Warung Madura Jaya</td>
                                <td class="px-6 py-4 text-slate-700 td-nowrap">Ahmad Dahlan</td>
                                <td class="px-6 py-4 font-medium text-slate-700 td-nowrap">Rp 350.000</td>
                                <td class="px-6 py-4 td-nowrap">
                                    <span
                                        class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-center td-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="show-merchant.html"
                                            class="btn btn-secondary btn-sm flex items-center gap-2">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
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
