@extends('dashboard.layouts.app')

@section('title', 'Daftar Produk')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <!-- Table Container -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <!-- Header Table -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
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

                    <a href="{{ route('products.create') }}" class="btn btn-primary rounded-xl" title="Tambah Produk">
                        <i class="fa-solid fa-plus font-semibold"></i> Tambah Produk
                    </a>
                </div>

                <!-- Main Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">#</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Gambar</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Nama Produk</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Kategori</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Merk</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Harga</th>
                                <th class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Status</th>
                                <th class="px-6 py-4 border-b border-slate-100 text-center font-semibold text-slate-800 uppercase tracking-wider td-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($products as $index => $product)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 text-slate-700 font-semibold td-nowrap">
                                        {{ $products->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                        @else
                                            <img src="https://placehold.co/100x100/f5f5f5/a3a3a3?text={{ urlencode(substr($product->name, 0, 3)) }}" alt="{{ $product->name }}"
                                                class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        <span class="font-semibold text-slate-700">{{ $product->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 font-medium td-nowrap">
                                        {{ $product->category?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-medium td-nowrap">
                                        {{ $product->merk ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-900 td-nowrap">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        @if ($product->is_active)
                                            <span class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm flex items-center gap-2"
                                                onclick="confirmDelete('{{ $product->id }}', '{{ $product->name }}')">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                            <form id="delete-form-{{ $product->id }}"
                                                action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data produk ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('dashboard.components.pagination', ['paginator' => $products])
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

            // SweetAlert Toast Notifications
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

        // Hapus Produk
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus produk " + name + ". Tindakan ini tidak dapat dibatalkan!",
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
