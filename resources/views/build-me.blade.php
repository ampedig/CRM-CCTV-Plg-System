<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Tambah Produk - Masum.xyz",
    "description": "Halaman Tambah Produk Baru"
    })
    <!-- Select2 CSS (Local) -->
    <link rel="stylesheet" href="assets/libs/select2/css/select2.min.css">
    <!-- Quill Editor CSS (Local) -->
    <link rel="stylesheet" href="assets/libs/quill/quill.snow.css">
    <link rel="stylesheet" href="assets/css/text-editor.page.css">
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
                                    <h2 class="text-lg font-semibold text-slate-800">Tambah Produk Baru</h2>
                                    <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk menambahkan
                                        item baru.</p>
                                </div>

                                <!-- 1. Upload Gambar (Dengan Preview) -->
                                <div class="mb-8">
                                    <label class="block text-sm font-semibold text-slate-700 mb-3">Foto Produk</label>
                                    <div
                                        class="w-full h-56 rounded-xl image-upload-area flex flex-col items-center justify-center cursor-pointer relative group overflow-hidden">
                                        <!-- Input File -->
                                        <input type="file" id="product-image"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                            accept="image/*">

                                        <!-- Placeholder Text (Default) -->
                                        <div id="upload-placeholder"
                                            class="text-center p-6 group-hover:-translate-y-1 transition-transform duration-300">
                                            <div
                                                class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-3 text-brand-600">
                                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-700">Klik untuk upload</p>
                                            <p class="text-xs text-slate-400 mt-1">atau drag & drop gambar disini</p>
                                            <p class="text-[10px] text-slate-300 mt-2">Max. 2MB (PNG, JPG)</p>
                                        </div>

                                        <!-- Image Preview (Hidden by default) -->
                                        <img id="image-preview" src="#" alt="Preview"
                                            class="absolute inset-0 w-full h-full object-contain p-2 hidden z-10">
                                    </div>
                                </div>

                                <!-- 2. Identitas Produk -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk <span
                                                class="text-danger">*</span></label>
                                        <input type="text" placeholder="Contoh: Kamera CCTV Hikvision Outdoor"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span
                                                class="text-danger">*</span></label>
                                        <select class="select2-category w-full">
                                            <option></option>
                                            <option value="cctv-indoor">CCTV Indoor</option>
                                            <option value="cctv-outdoor">CCTV Outdoor</option>
                                            <option value="dvr-nvr">DVR & NVR</option>
                                            <option value="accessories">Aksesoris CCTV</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Merk <span
                                                class="text-danger">*</span></label>
                                        <input type="text" placeholder="Contoh: Hikvision, Dahua"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Unit <span
                                                class="text-danger">*</span></label>
                                        <input type="text" placeholder="Contoh: pcs, meter, roll, pack"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Harga <span
                                                class="text-danger">*</span></label>
                                        <div class="relative">
                                            <span
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-semibold text-sm">Rp</span>
                                            <input type="number" placeholder="0"
                                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 font-medium">
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Deskripsi -->
                                <div class="mb-8">
                                    <label class="block text-sm font-semibold text-slate-700 mb-3">Deskripsi
                                        Lengkap</label>
                                    <!-- Wrapper class for focus styling -->
                                    <div class="editor-wrapper">
                                        <div id="quill-editor" style="min-height: 300px !important;"></div>
                                    </div>
                                </div>

                                <!-- 4. Status Toggles -->
                                <div class="mb-10">
                                    <div class="flex flex-col gap-4">
                                        <div
                                            class="flex items-center justify-between p-3 border border-slate-100 rounded-xl hover:bg-slate-50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div id="status-icon-bg"
                                                    class="p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300">
                                                    <i id="status-icon" class="fa-solid fa-power-off"></i>
                                                </div>
                                                <div>
                                                    <p id="status-text"
                                                        class="text-sm font-semibold text-slate-700 transition-colors duration-300">
                                                        Aktif</p>
                                                    <p id="status-desc"
                                                        class="text-xs text-slate-500 transition-colors duration-300">
                                                        Produk akan tampil dan bisa dibeli.</p>
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
                                    <a href="produk.html" class="btn btn-white">
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
    <script src="assets/libs/quill/quill.js"></script>

    <!-- Page Specific Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Select2 Initialization ---
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-category').select2({
                    placeholder: 'Pilih Kategori',
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });
            }

            // --- Quill Rich Text Editor Initialization ---
            if (document.getElementById('quill-editor')) {
                new Quill('#quill-editor', {
                    theme: 'snow',
                    placeholder: 'Ketikkan deskripsi lengkap produk...',
                    modules: {
                        toolbar: [
                            [{
                                'font': []
                            }, {
                                'size': ['small', false, 'large', 'huge']
                            }],
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'script': 'sub'
                            }, {
                                'script': 'super'
                            }],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }, {
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }],
                            [{
                                'direction': 'rtl'
                            }, {
                                'align': []
                            }],
                            ['clean']
                        ]
                    }
                });
            }

            // --- Status Toggle Logic ---
            const statusToggle = document.getElementById('status-toggle');
            const statusText = document.getElementById('status-text');
            const statusDesc = document.getElementById('status-desc');
            const statusIcon = document.getElementById('status-icon');
            const statusIconBg = document.getElementById('status-icon-bg');

            if (statusToggle && statusText && statusDesc && statusIcon && statusIconBg) {
                statusToggle.addEventListener('change', function() {
                    if (this.checked) {
                        statusText.innerText = 'Aktif';
                        statusDesc.innerText = 'Produk akan tampil dan bisa dibeli.';
                        statusIcon.className = 'fa-solid fa-power-off';
                        statusIconBg.className =
                            'p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300';
                    } else {
                        statusText.innerText = 'Nonaktif';
                        statusDesc.innerText = 'Produk disembunyikan dari aplikasi user.';
                        statusIcon.className = 'fa-solid fa-ban';
                        statusIconBg.className =
                            'p-2 bg-rose-50 text-rose-600 rounded-lg transition-colors duration-300';
                    }
                });
            }

            // --- Image Preview Logic ---
            const productImageInput = document.getElementById('product-image');
            const imagePreview = document.getElementById('image-preview');
            const uploadPlaceholder = document.getElementById('upload-placeholder');

            if (productImageInput && imagePreview && uploadPlaceholder) {
                productImageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                            uploadPlaceholder.classList.add('hidden');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.classList.add('hidden');
                        imagePreview.src = '#';
                        uploadPlaceholder.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
