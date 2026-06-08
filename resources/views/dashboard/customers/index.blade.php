@extends('dashboard.layouts.app')

@section('title', 'Data Pelanggan')

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

                        <a href="{{ route('customers.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Tambah Pelanggan
                        </a>
                    </div>
                </div>

                <!-- Main Table -->
                <div class="overflow-x-auto">
                    <table id="pelangganTable" class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    #</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Nama</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    WhatsApp</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Profesi</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Umur</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Konsultasi</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Kunjungan WEB</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Jumlah TRX</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-right t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Nominal TRX</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Lead Score</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Status</th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($customers as $index => $customer)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $customers->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $customer->full_name }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 td-nowrap">
                                        {{ $customer->whatsapp_number }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 td-nowrap">
                                        {{ $customer->occupation ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-700 td-nowrap">
                                        {{ $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->age : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        @if ($customer->consultation_frequency > 0)
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">Ya</span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-400 border border-slate-100">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-700 td-nowrap">
                                        {{ $customer->web_visit_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-700 td-nowrap">
                                        {{ $customer->transaction_count }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-slate-700 td-nowrap">
                                        Rp {{ number_format($customer->total_transaction_value, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        @if (strtolower($customer->lead_score_status) === 'hot')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                                Hot
                                            </span>
                                        @elseif (strtolower($customer->lead_score_status) === 'warm')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Warm
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Cold
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        @if ($customer->is_active)
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('customers.show', $customer->id ?? 0) }}"
                                                class="btn btn-white btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-eye text-slate-400"></i> Show
                                            </a>
                                            <a href="{{ route('customers.edit', $customer->id ?? 0) }}"
                                                class="btn btn-primary btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <button class="btn btn-danger btn-sm flex items-center gap-2"
                                                onclick="confirmDelete('{{ $customer->id }}', '{{ $customer->full_name }}')">
                                                <i class="fa-solid fa-trash-can"></i> Hapus
                                            </button>
                                            <form id="delete-form-{{ $customer->id }}"
                                                action="{{ route('customers.destroy', $customer->id ?? 0) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data pelanggan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('dashboard.components.pagination', ['paginator' => $customers])
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data pelanggan "${name}" akan dihapus secara permanen!`,
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
