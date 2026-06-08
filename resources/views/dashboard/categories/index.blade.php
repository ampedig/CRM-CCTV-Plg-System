@extends('dashboard.layouts.app')

@section('title', 'Kategori Blog')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <style>
        /* Custom styling to make color picker clean and perfectly rounded, removing browser defaults */
        #category-color-picker::-webkit-color-swatch-wrapper,
        #category-color-picker-edit::-webkit-color-swatch-wrapper {
            padding: 0 !important;
        }
        #category-color-picker::-webkit-color-swatch,
        #category-color-picker-edit::-webkit-color-swatch {
            border: none !important;
            border-radius: 12px !important;
        }
        #category-color-picker::-moz-color-swatch,
        #category-color-picker-edit::-moz-color-swatch {
            border: none !important;
            border-radius: 12px !important;
        }
    </style>
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <form action="{{ route('categories.index') }}" method="GET" class="flex items-center gap-2">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <span class="text-sm text-slate-500 font-medium">Show</span>
                        <select name="per_page" class="select2-show-entries w-24" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </form>

                    <button class="btn btn-primary rounded-xl" title="Tambah Kategori" id="btnTambahKategori">
                        <i class="fa-solid fa-plus font-semibold"></i> Tambah Kategori
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    #</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Nama Kategori</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Warna</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Total Produk</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($categories as $index => $category)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-slate-700 font-semibold td-nowrap">
                                        {{ $categories->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">{{ $category->name }}</td>
                                    <td class="px-6 py-4 td-nowrap">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-4 h-4 rounded-full border border-slate-200"
                                                style="background-color: {{ $category->color }};"></span>
                                            <code
                                                class="text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-lg uppercase">{{ $category->color }}</code>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-semibold text-xs">
                                            {{ $category->count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <button class="btn btn-primary btn-sm flex items-center gap-2 btn-edit-kategori"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                data-color="{{ $category->color }}">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm flex items-center gap-2"
                                                onclick="confirmDelete('{{ $category->id }}', '{{ $category->name }}')">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                            <form id="delete-form-{{ $category->id }}"
                                                action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data kategori ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('dashboard.components.pagination', ['paginator' => $categories])
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="modalTambahKategori" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" id="modalOverlay"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto w-full max-h-screen">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0" id="modalBackdrop">
                <div
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg rounded-2xl border border-slate-100">
                    <form action="{{ route('categories.store') }}" method="POST" class="mb-0">
                        @csrf
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
                                            class="text-rose-500">*</span></label>
                                    <input type="text" name="name" placeholder="Ketik nama kategori..."
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Warna Kategori <span
                                            class="text-rose-500">*</span></label>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="relative w-12 h-12 shrink-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 hover:border-brand-300 transition-colors">
                                            <input type="color" id="category-color-picker"
                                                value="{{ old('color', '#3B82F6') }}"
                                                class="absolute inset-0 w-full h-full cursor-pointer border-0 p-0 bg-transparent">
                                        </div>
                                        <input type="text" name="color" id="category-color-hex"
                                            value="{{ old('color', '#3B82F6') }}" placeholder="#FFFFFF" required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors uppercase font-mono font-medium text-slate-700">
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2 font-medium">Klik kotak warna di atas untuk
                                        memilih atau ketik kode Hex.</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-slate-50 border-t border-slate-100 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                            <button type="button" class="btn btn-white rounded-xl font-semibold w-full sm:w-auto"
                                id="btnCancelModal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary rounded-xl font-semibold w-full sm:w-auto">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="modalEditKategori" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" id="modalOverlayEdit"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto w-full max-h-screen">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0" id="modalBackdropEdit">
                <div
                    class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg rounded-2xl border border-slate-100">
                    <form id="formEditKategori" action="" method="POST" class="mb-0">
                        @csrf
                        @method('PUT')
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
                                            class="text-rose-500">*</span></label>
                                    <input type="text" id="edit-category-name" name="name"
                                        placeholder="Ketik nama kategori..."
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Warna Kategori <span
                                            class="text-rose-500">*</span></label>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="relative w-12 h-12 shrink-0 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 hover:border-brand-300 transition-colors">
                                            <input type="color" id="category-color-picker-edit"
                                                class="absolute inset-0 w-full h-full cursor-pointer border-0 p-0 bg-transparent">
                                        </div>
                                        <input type="text" name="color" id="category-color-hex-edit"
                                            placeholder="#FFFFFF" required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-brand-500 transition-colors uppercase font-mono font-medium text-slate-700">
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-2 font-medium">Klik kotak warna di atas untuk
                                        memilih atau ketik kode Hex.</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-slate-50 border-t border-slate-100 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                            <button type="button" class="btn btn-white rounded-xl font-semibold w-full sm:w-auto"
                                id="btnCancelModalEdit">Batal</button>
                            <button type="submit"
                                class="btn btn-primary rounded-xl font-semibold w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-show-entries').select2({
                    minimumResultsForSearch: Infinity
                });
            }

            // Modal Tambah Kategori
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
                modalBackdrop.addEventListener('click', (e) => {
                    if (e.target === modalBackdrop) {
                        toggleModal();
                    }
                });
            }

            // Color Picker Tambah Kategori
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

            // Modal Edit Kategori
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
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const color = this.getAttribute('data-color');

                        document.getElementById('edit-category-name').value = name;
                        document.getElementById('category-color-picker-edit').value = color;
                        document.getElementById('category-color-hex-edit').value = color;

                        const form = document.getElementById('formEditKategori');
                        // form.action expects standard REST format /categories/{id} but since we have a prefix from Route::resource it will be /categories/id
                        // Best way in Blade is to use a dummy URL and replace it
                        let url = "{{ route('categories.update', ':id') }}";
                        url = url.replace(':id', id);
                        form.action = url;

                        toggleModalEdit();
                    });
                });
                btnCloseEdit.addEventListener('click', toggleModalEdit);
                btnCancelEdit.addEventListener('click', toggleModalEdit);
                modalBackdropEdit.addEventListener('click', (e) => {
                    if (e.target === modalBackdropEdit) {
                        toggleModalEdit();
                    }
                });
            }

            // Color Picker Edit Kategori
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

            // SweetAlert Notifications
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Berhasil...!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Gagal...!',
                    text: '{{ $errors->first() }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });

        // Hapus Kategori
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus kategori " + name + ". Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'rounded-xl font-semibold px-6',
                    cancelButton: 'rounded-xl font-semibold text-slate-700 px-6'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
