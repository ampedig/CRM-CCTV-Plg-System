<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Tambah Pelanggan - Masum.xyz",
    "description": "Halaman Tambah Pelanggan Baru"
    })
    <!-- Select2 CSS (Local) -->
    <link rel="stylesheet" href="assets/libs/select2/css/select2.min.css">
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased">

    <div class="fixed inset-0 flex overflow-hidden bg-slate-50">

        @@include('../partials/sidebar.html')

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden lg:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            @@include('../partials/navbar.html')

            <!-- Scrollable Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">

                <!-- Content Wrapper -->
                <div class="flex-1 p-8">
                    <!-- Form Container (Single Component) -->
                    <div class="max-w-screen-2xl mx-auto">

                        <form action="javascript:void(0)" method="POST">
                            <!-- Wrapper Card Putih Besar -->
                            <div class="bg-white border border-slate-200 rounded-2xl p-8">

                                <!-- Header Kecil dalam Form -->
                                <div class="mb-8 pb-4 border-b border-slate-100">
                                    <h2 class="text-lg font-semibold text-slate-800">Tambah Pelanggan Baru</h2>
                                    <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk mendaftarkan
                                        pelanggan baru.</p>
                                </div>

                                <!-- Form Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" placeholder="Contoh: Rudi Hartono"
                                            required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp
                                            <span class="text-danger">*</span></label>
                                        <input type="tel" name="whatsapp" placeholder="Contoh: 081234567890"
                                            required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan <span
                                                class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                                        <input type="text" name="profession"
                                            placeholder="Contoh: Swasta, PNS, Pengusaha"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir
                                            <span class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                                        <input type="date" name="birth_date"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700 text-left">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pelanggan
                                            <span class="text-danger">*</span></label>
                                        <div
                                            class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100/50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div id="status-icon-bg"
                                                    class="p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300">
                                                    <i id="status-icon" class="fa-solid fa-user-check"></i>
                                                </div>
                                                <div>
                                                    <p id="status-text"
                                                        class="text-sm font-semibold text-slate-700 transition-colors duration-300">
                                                        Aktif</p>
                                                    <p id="status-desc"
                                                        class="text-xs text-slate-500 transition-colors duration-300">
                                                        Pelanggan dapat melakukan transaksi dan menerima promo.</p>
                                                </div>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="status-toggle" name="status" value="aktif"
                                                    class="sr-only peer" checked>
                                                <div
                                                    class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons (Bottom Left Aligned) -->
                                <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                                    <a href="pelanggan.html" class="btn btn-white">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-save"></i> Simpan
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                @@include('../partials/footer.html')
            </main>
        </div>
    </div>

    @@include('../partials/vendor-scripts.html')

    <!-- Page Specific Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusToggle = document.getElementById('status-toggle');
            const statusText = document.getElementById('status-text');
            const statusDesc = document.getElementById('status-desc');
            const statusIcon = document.getElementById('status-icon');
            const statusIconBg = document.getElementById('status-icon-bg');

            if (statusToggle && statusText && statusDesc && statusIcon && statusIconBg) {
                statusToggle.addEventListener('change', function() {
                    if (this.checked) {
                        statusText.innerText = 'Aktif';
                        statusDesc.innerText = 'Pelanggan dapat melakukan transaksi dan menerima promo.';

                        // Switch icon
                        statusIcon.className = 'fa-solid fa-user-check';

                        // Switch colors (emerald/green)
                        statusIconBg.className =
                            'p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300';
                    } else {
                        statusText.innerText = 'Nonaktif';
                        statusDesc.innerText =
                            'Pelanggan dinonaktifkan sementara dan tidak dapat bertransaksi.';

                        // Switch icon
                        statusIcon.className = 'fa-solid fa-user-xmark';

                        // Switch colors (rose/red)
                        statusIconBg.className =
                            'p-2 bg-rose-50 text-rose-600 rounded-lg transition-colors duration-300';
                    }
                });
            }
        });
    </script>
</body>

</html>
