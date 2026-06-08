<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Chat History - Masum.xyz",
    "description": "Riwayat Pesan Pelanggan"
    })
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
                <div class="flex-1 p-8">
                    <div class="max-w-screen-2xl mx-auto">
                        <!-- Table Container -->
                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                            <!-- Header Table -->
                            <div
                                class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-slate-500 font-medium">Show</span>
                                    <select class="select2-show-entries w-24">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Main Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead
                                        class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                                        <tr>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                #</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Nama Pelanggan</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Whatsapp</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">1</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Ahmad Fauzi
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 td-nowrap">081234567890</td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button onclick="showModal('showChatModal')"
                                                        class="btn btn-primary btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-eye"></i> Show
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">2</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Dewi Lestari
                                            </td>
                                            <td class="px-6 py-4 text-slate-700 td-nowrap">085612349876</td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button onclick="showModal('showChatModal')"
                                                        class="btn btn-primary btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-eye"></i> Show
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">3</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Bambang
                                                Hermawan</td>
                                            <td class="px-6 py-4 text-slate-700 td-nowrap">081987654321</td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button onclick="showModal('showChatModal')"
                                                        class="btn btn-primary btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-eye"></i> Show
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination (opsional tapi standar) -->
                            <div
                                class="p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <span class="text-xs text-slate-500 font-medium">Menampilkan <span
                                        class="font-semibold text-slate-700">1-3</span> dari <span
                                        class="font-semibold text-slate-700">120</span> data</span>
                                <nav aria-label="Page navigation">
                                    <ul class="inline-flex items-center -space-x-px">
                                        <li>
                                            <a href="#"
                                                class="flex items-center justify-center w-9 h-9 ml-0 leading-tight text-slate-500 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 hover:text-slate-700 transition">
                                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center justify-center w-9 h-9 text-brand-600 border border-brand-100 bg-brand-50 hover:bg-brand-100 hover:text-brand-700 transition font-semibold text-sm">1</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center justify-center w-9 h-9 leading-tight text-slate-500 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50 hover:text-slate-700 transition">
                                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                @@include('../partials/footer.html')
            </main>
        </div>
    </div>

    <!-- Modal Show Chat -->
    <div id="showChatModal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="hideModal('showChatModal')"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full scale-95 opacity-0 duration-300"
                id="showChatModalContent">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Detail Pesan Masuk</h3>
                    <button type="button" onclick="hideModal('showChatModal')"
                        class="text-slate-400 hover:text-slate-500 hover:bg-slate-100 p-2 rounded-xl transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pelanggan</label>
                            <input type="text" value="Ahmad Fauzi" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Whatsapp</label>
                            <input type="text" value="081234567890" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan</label>
                            <textarea rows="6" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed resize-none leading-relaxed">Halo, saya ingin bertanya tentang paket pemasangan CCTV outdoor. Apakah ada promo bulan ini?</textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50">
                    <button type="button" onclick="hideModal('showChatModal')" class="btn btn-white">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @@include('../partials/vendor-scripts.html')
    <script src="assets/libs/select2/js/select2.min.js"></script>

    <!-- Page Specific Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-show-entries').select2({
                    minimumResultsForSearch: Infinity
                });
            }
        });

        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            if (modal && content) {
                modal.classList.remove('hidden');
                // Trigger reflow
                void modal.offsetWidth;
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            if (modal && content) {
                modal.classList.add('opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }
    </script>
</body>

</html>
