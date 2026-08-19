@extends('dashboard.layouts.app')

@section('title', 'Data Transaksi')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">

            <!-- Table Container -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <!-- Header Table -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <!-- Show Entries -->
                    <div class="hidden md:flex items-center gap-2 mr-2">
                        <form action="{{ route('transactions.index') }}" method="GET" class="flex items-center gap-2">
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
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Atur Kolom -->
                        <div class="relative">
                            <button id="btnColumns"
                                class="w-full md:w-auto px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-600 font-medium text-sm hover:bg-slate-50 hover:text-slate-900 transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-table-columns"></i> Atur Kolom <i
                                    class="fa-solid fa-chevron-down text-xs ml-1"></i>
                            </button>

                            <!-- Column Dropdown Menu -->
                            <div id="columnMenu"
                                class="hidden absolute right-0 top-full mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-lg shadow-slate-200/50 z-50 p-2">
                                <div class="text-xs font-semibold text-slate-400 uppercase px-3 py-2">
                                    Tampilkan Kolom</div>
                                <!-- Container for Dynamic Columns -->
                                <div id="columnListContainer" class="space-y-1 max-h-60 overflow-y-auto custom-scrollbar">
                                    <!-- Checkboxes will be injected here by JS -->
                                    <div class="px-3 py-2 text-xs text-slate-400">Loading kolom...</div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('transactions.export', ['search' => request('search')]) }}" class="btn btn-success rounded-xl">
                            <i class="fa-solid fa-file-excel"></i> Export Excel
                        </a>

                        <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-xl">
                            <i class="fa-solid fa-plus"></i> Tambah Transaksi
                        </a>
                    </div>
                </div>

                <!-- Main Table -->
                <div class="overflow-x-auto">
                    <table id="transaksiTable" class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    #</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Pelanggan</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Total</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Status Pembayaran</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($transactions as $index => $transaction)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $transactions->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 td-nowrap">
                                        {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $transaction->customer?->full_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 td-nowrap">
                                        @if ($transaction->payment_status === 'paid')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700">Paid</span>
                                        @elseif ($transaction->payment_status === 'pending')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                        @elseif ($transaction->payment_status === 'canceled')
                                            <span
                                                class="inline-block px-3 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700">Canceled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                                class="btn btn-primary btn-icon btn-sm" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                class="btn btn-primary btn-icon btn-sm" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button class="btn btn-danger btn-icon btn-sm" title="Hapus"
                                                onclick="confirmDelete('{{ $transaction->id }}', '{{ $transaction->customer?->full_name }}')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <form id="delete-form-{{ $transaction->id }}"
                                                action="{{ route('transactions.destroy', $transaction->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data transaksi ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('dashboard.components.pagination', ['paginator' => $transactions])
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/transaksi.page.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data transaksi ${name} akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                customClass: {
                    confirmButton: 'rounded-xl font-semibold px-6',
                    cancelButton: 'rounded-xl font-semibold text-slate-700 px-6'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
