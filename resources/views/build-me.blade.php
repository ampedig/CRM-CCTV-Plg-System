<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Detail Transaksi - Masum.xyz",
    "description": "Halaman Detail Transaksi"
    })
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .print-panel {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased">

    <div class="fixed inset-0 flex overflow-hidden bg-slate-50">

        @@include('../partials/sidebar.html')

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden lg:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            @@include('../partials/navbar.html')

            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">
                <div class="flex-1 p-4 md:p-8">
                    <div class="w-full">

                        <!-- Page Header -->
                        <div
                            class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print">
                            <div>
                                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                                    <a href="transaksi.html"
                                        class="hover:text-brand-600 transition-colors">Transaksi</a>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    <span class="text-slate-700 font-semibold">#TRX-0089</span>
                                </div>
                                <h2 class="text-2xl font-semibold text-slate-800">Detail Transaksi</h2>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="window.print()"
                                    class="btn btn-sm bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center gap-2">
                                    <i class="fa-solid fa-print"></i> Print Struk
                                </button>
                                <a href="transaksi.html" class="btn btn-white btn-sm flex items-center gap-2">
                                    <i class="fa-solid fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <!-- Single Panel -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 lg:p-8 space-y-8 print-panel">

                            <!-- Header Struk -->
                            <div
                                class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-100">
                                <div>
                                    <h3 class="text-xl font-semibold text-slate-800">Invoice Transaksi</h3>
                                    <p class="text-sm text-slate-500 mt-1">Diterbitkan pada 24 Desember 2025, 10:45 WIB
                                    </p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">No.
                                        Transaksi</p>
                                    <p class="text-lg font-semibold text-slate-800">#TRX-0089</p>
                                    <span
                                        class="inline-block mt-2 px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Sukses</span>
                                </div>
                            </div>

                            <!-- Info Pelanggan & Pembayaran -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 rounded-xl p-5">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
                                        Informasi Pelanggan</p>
                                    <div class="space-y-2">
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-user text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">Nama</p>
                                                <p class="text-sm font-semibold text-slate-800">Rudi Hartono</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-phone text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">No. WhatsApp</p>
                                                <p class="text-sm font-semibold text-slate-800">0812-3456-7890</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-location-dot text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">Alamat</p>
                                                <p class="text-sm font-semibold text-slate-800">Jl. Mawar No. 12, Bekasi
                                                    Utara</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 rounded-xl p-5">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
                                        Informasi Pembayaran</p>
                                    <div class="space-y-2">
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-calendar text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">Tanggal</p>
                                                <p class="text-sm font-semibold text-slate-800">24 Desember 2025, 10:45
                                                    WIB</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-credit-card text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">Metode Bayar</p>
                                                <p class="text-sm font-semibold text-slate-800">Transfer Bank (BCA)</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3">
                                            <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                                    class="fa-solid fa-circle-check text-xs"></i></span>
                                            <div>
                                                <p class="text-xs text-slate-400">Status Pembayaran</p>
                                                <span
                                                    class="inline-block mt-0.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-green-100 text-green-700">Sukses
                                                    / Lunas</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Daftar Produk -->
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Daftar
                                    Barang Yang Dibeli</p>
                                <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left min-w-[560px]">
                                            <thead
                                                class="bg-slate-100/70 text-slate-500 text-xs uppercase tracking-wider">
                                                <tr>
                                                    <th class="p-4 font-semibold">Produk</th>
                                                    <th class="p-4 font-semibold text-right w-40">Harga Satuan</th>
                                                    <th class="p-4 font-semibold text-center w-24">Qty</th>
                                                    <th class="p-4 font-semibold text-right w-40">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 bg-white text-sm">

                                                <!-- Item 1 -->
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                                <img src="https://placehold.co/100x100/e2e8f0/64748b?text=CCTV"
                                                                    alt="CCTV" class="w-full h-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold text-slate-800">Kamera CCTV
                                                                    Hikvision 2MP Indoor</p>
                                                                <p class="text-xs text-slate-400">Hikvision</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-right text-slate-600">Rp 350.000</td>
                                                    <td class="p-4 text-center text-slate-700 font-semibold">4</td>
                                                    <td class="p-4 text-right font-semibold text-slate-800">Rp 1.400.000
                                                    </td>
                                                </tr>

                                                <!-- Item 2 -->
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                                <img src="https://placehold.co/100x100/e2e8f0/64748b?text=DVR"
                                                                    alt="DVR" class="w-full h-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold text-slate-800">DVR Dahua 4
                                                                    Channel 1080p</p>
                                                                <p class="text-xs text-slate-400">Dahua</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-right text-slate-600">Rp 650.000</td>
                                                    <td class="p-4 text-center text-slate-700 font-semibold">1</td>
                                                    <td class="p-4 text-right font-semibold text-slate-800">Rp 650.000
                                                    </td>
                                                </tr>

                                                <!-- Item 3 -->
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                                <img src="https://placehold.co/100x100/e2e8f0/64748b?text=HDD"
                                                                    alt="HDD" class="w-full h-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold text-slate-800">Hardisk Seagate
                                                                    Skyhawk 1TB</p>
                                                                <p class="text-xs text-slate-400">Seagate</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-right text-slate-600">Rp 850.000</td>
                                                    <td class="p-4 text-center text-slate-700 font-semibold">1</td>
                                                    <td class="p-4 text-right font-semibold text-slate-800">Rp 850.000
                                                    </td>
                                                </tr>

                                                <!-- Item 4 -->
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                                <img src="https://placehold.co/100x100/e2e8f0/64748b?text=KABEL"
                                                                    alt="Kabel" class="w-full h-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold text-slate-800">Kabel Coaxial
                                                                    RG59 + Power (50m)</p>
                                                                <p class="text-xs text-slate-400">SPC</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-right text-slate-600">Rp 150.000</td>
                                                    <td class="p-4 text-center text-slate-700 font-semibold">2</td>
                                                    <td class="p-4 text-right font-semibold text-slate-800">Rp 300.000
                                                    </td>
                                                </tr>

                                                <!-- Item 5 -->
                                                <tr>
                                                    <td class="p-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                                <img src="https://placehold.co/100x100/e2e8f0/64748b?text=JASA"
                                                                    alt="Jasa" class="w-full h-full object-cover">
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold text-slate-800">Jasa Instalasi
                                                                    per Titik</p>
                                                                <p class="text-xs text-slate-400">Service</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-right text-slate-600">Rp 200.000</td>
                                                    <td class="p-4 text-center text-slate-700 font-semibold">4</td>
                                                    <td class="p-4 text-right font-semibold text-slate-800">Rp 800.000
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Totals Footer -->
                                    <div class="bg-slate-50 border-t border-slate-200 p-5">
                                        <div class="flex justify-end">
                                            <div class="w-full max-w-xs space-y-2">
                                                <div class="flex justify-between text-sm text-slate-500">
                                                    <span>Subtotal (12 item)</span>
                                                    <span class="font-semibold text-slate-700">Rp 4.000.000</span>
                                                </div>
                                                <div class="flex justify-between text-sm text-slate-500">
                                                    <span>Diskon</span>
                                                    <span class="font-semibold text-green-600">- Rp 0</span>
                                                </div>
                                                <div class="flex justify-between text-sm text-slate-500">
                                                    <span>Ongkos Kirim</span>
                                                    <span class="font-semibold text-slate-700">Rp 0</span>
                                                </div>
                                                <div
                                                    class="pt-3 border-t border-slate-200 flex justify-between items-center">
                                                    <span class="text-base font-semibold text-slate-800">Grand
                                                        Total</span>
                                                    <span class="text-2xl font-semibold text-brand-600">Rp
                                                        4.000.000</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Catatan
                                </p>
                                <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-600">
                                    Pemasangan di lokasi rumah pelanggan. Sudah termasuk material kabel dan ongkos
                                    pasang per titik. Garansi kamera 1 tahun.
                                </div>
                            </div>

                            <!-- Action Footer -->
                            <div
                                class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-between items-center no-print">
                                <a href="transaksi.html"
                                    class="btn btn-white flex items-center gap-2 order-2 sm:order-1">
                                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                <div class="flex gap-3 order-1 sm:order-2">
                                    <button onclick="window.print()"
                                        class="btn bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center gap-2">
                                        <i class="fa-solid fa-print"></i> Print Struk
                                    </button>
                                    <a href="edit-transaksi.html" class="btn btn-primary flex items-center gap-2">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit Transaksi
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @@include('../partials/footer.html')
            </main>
        </div>
    </div>

    @@include('../partials/vendor-scripts.html')

</body>

</html>
