@extends('dashboard.layouts.app')

@section('title', 'Edit Produk')

@section('head')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <!-- Quill Editor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/text-editor.page.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <form id="productForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Wrapper Card Putih Besar -->
                <div class="bg-white border border-slate-200 rounded-2xl p-8">

                    <!-- Header Kecil dalam Form -->
                    <div class="mb-8 pb-4 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800">Edit Produk: {{ $product->name }}</h2>
                        <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk memperbarui item ini.</p>
                    </div>

                    <!-- 1. Upload Gambar (Dengan Preview) -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Foto Produk</label>
                        <div class="w-full h-56 rounded-xl image-upload-area flex flex-col items-center justify-center cursor-pointer relative group overflow-hidden">
                            <!-- Input File -->
                            <input type="file" id="product-image" name="image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                accept="image/*">

                            <!-- Placeholder Text (Default) -->
                            <div id="upload-placeholder" class="text-center p-6 group-hover:-translate-y-1 transition-transform duration-300 {{ $product->image ? 'hidden' : '' }}">
                                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-3 text-brand-600">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Klik untuk upload</p>
                                <p class="text-xs text-slate-400 mt-1">atau drag & drop gambar disini</p>
                                <p class="text-[10px] text-slate-300 mt-2">Max. 2MB (PNG, JPG)</p>
                            </div>

                            <!-- Image Preview -->
                            <img id="image-preview" src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}" alt="Preview"
                                class="absolute inset-0 w-full h-full object-contain p-2 {{ $product->image ? '' : 'hidden' }} z-10">
                        </div>
                        @error('image')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Identitas Produk -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: Kamera CCTV Hikvision Outdoor" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('name')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                            <select name="category_id" class="select2-category w-full" required>
                                <option></option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Merk <span class="text-rose-500">*</span></label>
                            <input type="text" name="merk" value="{{ old('merk', $product->merk) }}" placeholder="Contoh: Hikvision, Dahua" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('merk')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Unit <span class="text-rose-500">*</span></label>
                            <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" placeholder="Contoh: pcs, meter, roll, pack" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('unit')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-semibold text-sm">Rp</span>
                                <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" placeholder="0" required min="0" step="any"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 font-medium text-slate-700">
                            </div>
                            @error('price')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 3. Deskripsi -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Deskripsi Lengkap</label>
                        <!-- Hidden Input for description -->
                        <input type="hidden" name="description" id="product-description-input" value="{{ old('description', $product->description) }}">
                        <div class="editor-wrapper">
                            <div id="quill-editor" style="min-height: 300px !important;"></div>
                        </div>
                        @error('description')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. Status Toggles -->
                    <div class="mb-10">
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center justify-between p-3 border border-slate-100 rounded-xl hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div id="status-icon-bg" class="p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300">
                                        <i id="status-icon" class="fa-solid fa-power-off"></i>
                                    </div>
                                    <div>
                                        <p id="status-text" class="text-sm font-semibold text-slate-700 transition-colors duration-300">Aktif</p>
                                        <p id="status-desc" class="text-xs text-slate-500 transition-colors duration-300">Produk akan tampil dan bisa dibeli.</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" id="status-toggle" name="is_active" value="1" class="sr-only peer"
                                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <div id="toggle-bg" class="w-11 h-6 {{ old('is_active', $product->is_active) ? 'bg-emerald-500' : 'bg-rose-500' }} peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-white rounded-xl">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary rounded-xl">
                            <i class="fa-solid fa-save"></i> Simpan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- Quill Editor JS -->
    <script src="{{ asset('assets/libs/quill/quill.js') }}"></script>

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
            const quillContainer = document.getElementById('quill-editor');
            const descInput = document.getElementById('product-description-input');
            if (quillContainer) {
                const quill = new Quill('#quill-editor', {
                    theme: 'snow',
                    placeholder: 'Ketikkan deskripsi lengkap produk...',
                    modules: {
                        toolbar: [
                            [{ 'font': [] }, { 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'sub' }, { 'script': 'super' }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }, { 'align': [] }],
                            ['clean']
                        ]
                    }
                });

                // Load existing description
                if (descInput.value) {
                    quill.root.innerHTML = descInput.value;
                }

                // Copy Quill html text to hidden input on submit
                const form = document.getElementById('productForm');
                if (form) {
                    form.addEventListener('submit', () => {
                        descInput.value = quill.root.innerHTML;
                    });
                }
            }

            // --- Status Toggle Logic ---
            const statusToggle = document.getElementById('status-toggle');
            const statusText = document.getElementById('status-text');
            const statusDesc = document.getElementById('status-desc');
            const statusIcon = document.getElementById('status-icon');
            const statusIconBg = document.getElementById('status-icon-bg');
            const toggleBg = document.getElementById('toggle-bg');

            if (statusToggle && statusText && statusDesc && statusIcon && statusIconBg && toggleBg) {
                const updateStatusView = () => {
                    if (statusToggle.checked) {
                        statusText.innerText = 'Aktif';
                        statusDesc.innerText = 'Produk akan tampil dan bisa dibeli.';
                        statusIcon.className = 'fa-solid fa-power-off';
                        statusIconBg.className = 'p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-rose-500');
                        toggleBg.classList.add('bg-emerald-500');
                    } else {
                        statusText.innerText = 'Nonaktif';
                        statusDesc.innerText = 'Produk disembunyikan dari aplikasi user.';
                        statusIcon.className = 'fa-solid fa-ban';
                        statusIconBg.className = 'p-2 bg-rose-50 text-rose-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-emerald-500');
                        toggleBg.classList.add('bg-rose-500');
                    }
                };

                statusToggle.addEventListener('change', updateStatusView);
                updateStatusView(); // Trigger once on load
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
@endsection
