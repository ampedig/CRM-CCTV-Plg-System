<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Kategori Blog - Masum.xyz",
    "description": "Halaman Kategori Blog"
    })
    <link rel="stylesheet" href="assets/libs/select2/css/select2.min.css">
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased">

    <div class="flex h-screen overflow-hidden bg-slate-50">

        @@include('../partials/sidebar.html')

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden lg:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            @@include('../partials/navbar.html')

            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">

                <!-- Content Wrapper -->
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

                                <button class="btn btn-primary rounded-xl" title="Tambah Kategori"
                                    id="btnTambahKategori">
                                    <i class="fa-solid fa-plus font-semibold"></i> Tambah Kategori
                                </button>
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
                                                Nama Kategori</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Warna</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Total Produk</th>
                                            <th
                                                class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-sm">
                                        <!-- Item 1 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-slate-700 font-semibold td-nowrap">1</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Marketing</td>
                                            <td class="px-6 py-4 td-nowrap">
                                                <div class="flex items-center gap-2.5">
                                                    <span
                                                        class="w-4 h-4 rounded-full bg-[#10B981] border border-emerald-600/20"></span>
                                                    <code
                                                        class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-lg">#10B981</code>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-semibold text-xs">
                                                    24
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button
                                                        class="btn btn-primary btn-sm flex items-center gap-2 btn-edit-kategori">
                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Item 2 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-slate-700 font-semibold td-nowrap">2</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">Teknologi</td>
                                            <td class="px-6 py-4 td-nowrap">
                                                <div class="flex items-center gap-2.5">
                                                    <span
                                                        class="w-4 h-4 rounded-full bg-[#3B82F6] border border-blue-600/20"></span>
                                                    <code
                                                        class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-lg">#3B82F6</code>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-semibold text-xs">
                                                    42
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button
                                                        class="btn btn-primary btn-sm flex items-center gap-2 btn-edit-kategori">
                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Item 3 -->
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 text-slate-700 font-semibold td-nowrap">3</td>
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">UI/UX Design
                                            </td>
                                            <td class="px-6 py-4 td-nowrap">
                                                <div class="flex items-center gap-2.5">
                                                    <span
                                                        class="w-4 h-4 rounded-full bg-[#6366F1] border border-indigo-600/20"></span>
                                                    <code
                                                        class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-lg">#6366F1</code>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-semibold text-xs">
                                                    15
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center td-nowrap">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button
                                                        class="btn btn-primary btn-sm flex items-center gap-2 btn-edit-kategori">
                                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                                    </button>
                                                    <button class="btn btn-danger btn-sm flex items-center gap-2">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div
                                class="p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <span class="text-xs text-slate-500 font-medium">Menampilkan <span
                                        class="font-semibold text-slate-700">1-3</span> dari <span
                                        class="font-semibold text-slate-700">3</span> data</span>

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
                                                class="flex items-center justify-center w-9 h-9 leading-tight text-brand-600 bg-brand-50 border border-brand-200 font-semibold z-10 transition">1</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center justify-center w-9 h-9 leading-tight text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-700 transition">2</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center justify-center w-9 h-9 leading-tight text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-700 transition">3</a>
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

                <!-- Footer -->
                <footer
                    class="shrink-0 border-t border-slate-100 bg-white h-[76px] flex items-center justify-center text-sm text-slate-400 font-medium">
                    &copy; 2026 Masum.xyz
                </footer>
            </main>
        </div>
    </div>



    <!-- Modal Tambah Kategori -->
    <div id="modalTambahKategori" class="fixed inset-0 z-50 hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" id="modalOverlay"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto w-full max-h-screen">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0" id="modalBackdrop">
                <div
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg rounded-2xl border border-slate-100">

                    <form action="javascript:void(0)" class="mb-0">
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-slate-800">Tambah Kategori Baru</h3>
                                    <p class="text-xs text-slate-500 mt-1">Lengkapi data untuk kategori blog baru.</p>
                                </div>
                                <button type="button"
                                    class="text-slate-400 hover:text-slate-600 transition-colors w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-100"
                                    id="btnCloseModal">
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Ketik nama kategori..."
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Warna Kategori <span
                                            class="text-danger">*</span></label>
                                    <div class="flex items-center gap-3">
                                        <!-- Color Picker Cube -->
                                        <div
                                            class="relative w-12 h-12 shrink-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 hover:border-brand-300 transition-colors">
                                            <input type="color" id="category-color-picker" value="#3B82F6"
                                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200%] h-[200%] cursor-pointer border-0 p-0 bg-transparent">
                                        </div>
                                        <!-- Hex Text Input -->
                                        <input type="text" id="category-color-hex" value="#3B82F6"
                                            placeholder="#FFFFFF" required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors uppercase font-mono font-medium text-slate-700">
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2 font-medium">Klik kotak warna di atas
                                        untuk memilih atau ketik kode Hex.</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-slate-50 border-t border-slate-100 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                            <button type="button" class="btn btn-white rounded-xl font-semibold w-full sm:w-auto"
                                id="btnCancelModal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary rounded-xl font-semibold w-full sm:w-auto">Simpan
                                Kategori</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="modalEditKategori" class="fixed inset-0 z-50 hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" id="modalOverlayEdit"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto w-full max-h-screen">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0" id="modalBackdropEdit">
                <div
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg rounded-2xl border border-slate-100">

                    <form action="javascript:void(0)" class="mb-0">
                        <div class="bg-white px-6 pb-6 pt-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-slate-800">Edit Kategori</h3>
                                    <p class="text-xs text-slate-500 mt-1">Ubah data kategori blog ini.</p>
                                </div>
                                <button type="button"
                                    class="text-slate-400 hover:text-slate-600 transition-colors w-8 h-8 flex items-center justify-center rounded-xl hover:bg-slate-100"
                                    id="btnCloseModalEdit">
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Ketik nama kategori..." value="Marketing"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Warna Kategori <span
                                            class="text-danger">*</span></label>
                                    <div class="flex items-center gap-3">
                                        <!-- Color Picker Cube -->
                                        <div
                                            class="relative w-12 h-12 shrink-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 hover:border-brand-300 transition-colors">
                                            <input type="color" id="category-color-picker-edit" value="#10B981"
                                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200%] h-[200%] cursor-pointer border-0 p-0 bg-transparent">
                                        </div>
                                        <!-- Hex Text Input -->
                                        <input type="text" id="category-color-hex-edit" value="#10B981"
                                            placeholder="#FFFFFF" required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors uppercase font-mono font-medium text-slate-700">
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2 font-medium">Klik kotak warna di atas
                                        untuk memilih atau ketik kode Hex.</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-slate-50 border-t border-slate-100 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                            <button type="button" class="btn btn-white rounded-xl font-semibold w-full sm:w-auto"
                                id="btnCancelModalEdit">Batal</button>
                            <button type="submit"
                                class="btn btn-primary rounded-xl font-semibold w-full sm:w-auto">Simpan
                                Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @@include('../partials/vendor-scripts.html')
    <script src="assets/libs/select2/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Select2 Init
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-show-entries').select2({
                    minimumResultsForSearch: Infinity
                });
            }

            // Modal Tambah Kategori Logic
            const modal = document.getElementById('modalTambahKategori');
            const btnOpen = document.getElementById('btnTambahKategori');
            const btnClose = document.getElementById('btnCloseModal');
            const btnCancel = document.getElementById('btnCancelModal');
            const modalBackdrop = document.getElementById('modalBackdrop');

            const toggleModal = () => {
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            };

            if (btnOpen && modal) {
                btnOpen.addEventListener('click', toggleModal);
                btnClose.addEventListener('click', toggleModal);
                btnCancel.addEventListener('click', toggleModal);

                // Allow closing when clicking outside the modal content
                modalBackdrop.addEventListener('click', (e) => {
                    if (e.target === modalBackdrop) {
                        toggleModal();
                    }
                });
            }

            // Link color picker and hex text input in modal
            const colorPicker = document.getElementById('category-color-picker');
            const colorHexInput = document.getElementById('category-color-hex');

            if (colorPicker && colorHexInput) {
                colorPicker.addEventListener('input', (e) => {
                    colorHexInput.value = e.target.value.toUpperCase();
                });

                colorHexInput.addEventListener('input', (e) => {
                    let val = e.target.value;
                    if (val && !val.startsWith('#')) {
                        val = '#' + val;
                    }
                    if (/^#[0-9A-F]{6}$/i.test(val)) {
                        colorPicker.value = val;
                    }
                });
            }

            // Modal Edit Kategori Logic
            const modalEdit = document.getElementById('modalEditKategori');
            const btnEditList = document.querySelectorAll('.btn-edit-kategori');
            const btnCloseEdit = document.getElementById('btnCloseModalEdit');
            const btnCancelEdit = document.getElementById('btnCancelModalEdit');
            const modalBackdropEdit = document.getElementById('modalBackdropEdit');

            const toggleModalEdit = () => {
                if (modalEdit.classList.contains('hidden')) {
                    modalEdit.classList.remove('hidden');
                } else {
                    modalEdit.classList.add('hidden');
                }
            };

            if (modalEdit) {
                btnEditList.forEach(btn => {
                    btn.addEventListener('click', toggleModalEdit);
                });
                btnCloseEdit.addEventListener('click', toggleModalEdit);
                btnCancelEdit.addEventListener('click', toggleModalEdit);

                // Allow closing when clicking outside the modal content
                modalBackdropEdit.addEventListener('click', (e) => {
                    if (e.target === modalBackdropEdit) {
                        toggleModalEdit();
                    }
                });
            }

            // Link color picker and hex text input in Edit modal
            const colorPickerEdit = document.getElementById('category-color-picker-edit');
            const colorHexInputEdit = document.getElementById('category-color-hex-edit');

            if (colorPickerEdit && colorHexInputEdit) {
                colorPickerEdit.addEventListener('input', (e) => {
                    colorHexInputEdit.value = e.target.value.toUpperCase();
                });

                colorHexInputEdit.addEventListener('input', (e) => {
                    let val = e.target.value;
                    if (val && !val.startsWith('#')) {
                        val = '#' + val;
                    }
                    if (/^#[0-9A-F]{6}$/i.test(val)) {
                        colorPickerEdit.value = val;
                    }
                });
            }
        });
    </script>
</body>

</html>
