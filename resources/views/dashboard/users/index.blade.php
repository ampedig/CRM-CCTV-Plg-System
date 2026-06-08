@extends('dashboard.layouts.app')

@section('title', 'Data Pengguna')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">

            <!-- Table Container -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <!-- Header Table -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500 font-medium">Show</span>
                        <select class="select2-show-entries w-24" onchange="changePerPage(this.value)">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Tambah Pengguna
                    </a>
                </div>

                <!-- Main Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    #
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Nama
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Role
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($users as $index => $user)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $users->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 td-nowrap">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        @if ($user->role === 'admin')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                Admin
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Sales
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-primary btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm flex items-center gap-2"
                                                onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="hidden" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data pengguna ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('dashboard.components.pagination', ['paginator' => $users])

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        /**
         * Mengatur jumlah data per halaman dan tetap mempertahankan parameter pencarian.
         */
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('page', 1); // Reset ke halaman 1 saat mengubah per page
            window.location.href = url.toString();
        }

        /**
         * Menampilkan konfirmasi pop-up sebelum menghapus pengguna.
         */
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data pengguna "${name}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil...!',
                    text: "{{ session('success') }}"
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Gagal...!',
                    text: "{{ session('error') }}"
                });
            });
        </script>
    @endif
@endsection
