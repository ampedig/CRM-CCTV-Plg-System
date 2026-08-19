@extends('dashboard.layouts.app')

@section('title', 'Detail Pelanggan')

@section('head')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">

            <!-- Back Button -->
            <a href="{{ route('customers.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition mb-6">
                <i class="fa-solid fa-arrow-left-long"></i>
                <span>Kembali ke Daftar Pelanggan</span>
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Customer Profile Card -->
                <div class="lg:col-span-1 flex flex-col gap-6">
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col items-center text-center">

                        <!-- Initials Avatar -->
                        <div
                            class="w-20 h-20 bg-brand-50 rounded-3xl flex items-center justify-center text-brand-600 font-bold text-3xl mb-4 border border-brand-100">
                            {{ strtoupper(substr($customer->full_name, 0, 2)) }}
                        </div>

                        <h2 class="text-xl font-bold text-slate-800 mb-1">{{ $customer->full_name }}</h2>
                        <p class="text-slate-400 text-sm mb-4">{{ $customer->occupation ?? 'Tidak ada data pekerjaan' }}</p>

                        <!-- Detail Fields -->
                        <div class="w-full border-t border-slate-100 pt-4 text-left flex flex-col gap-3.5 text-sm">
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">No. WhatsApp</span>
                                <span class="text-slate-700 font-semibold">+{{ $customer->whatsapp_number }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Tanggal Lahir</span>
                                <span
                                    class="text-slate-700 font-semibold">{{ $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->translatedFormat('d F Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Usia</span>
                                <span
                                    class="text-slate-700 font-semibold">{{ $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->age . ' Tahun' : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Status Akun</span>
                                @if ($customer->is_active)
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">Nonaktif</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Status Pembayaran</span>
                                @if ($customer->payment_status === 'Lunas')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-100">Lunas</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-100">Belum
                                        Lunas</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Skor Calon Pembeli</span>
                                @if (strtolower($customer->lead_score_status) === 'hot')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-100">Hot</span>
                                @elseif (strtolower($customer->lead_score_status) === 'warm')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-100">Warm</span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">Cold</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Frekuensi Konsultasi</span>
                                <span class="text-slate-700 font-semibold">{{ $customer->consultation_frequency }}
                                    kali</span>
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Kunjungan Website</span>
                                <span class="text-slate-700 font-semibold">{{ $customer->web_visit_count }} kali</span>
                            </div>
                            <div class="flex justify-between items-center pb-3.5 border-b border-slate-50">
                                <span class="text-slate-400 font-medium">Total Nilai Transaksi</span>
                                <span class="text-slate-700 font-semibold">Rp {{ number_format($customer->total_transaction_value, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-medium">Minat Kategori</span>
                                <span
                                    class="text-slate-700 font-semibold capitalize">{{ $customer->last_product_interest ?? 'Belum ada data' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Transactions History -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                        <!-- Table Header -->
                        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-bold text-slate-800">Riwayat Transaksi</h3>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Menampilkan total
                                    {{ $customer->transaction_count }} transaksi pembelian</p>
                            </div>
                        </div>

                        <!-- Transactions Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                                    <tr>
                                        <th
                                            class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                            #</th>
                                        <th
                                            class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                            Total Belanja</th>
                                        <th
                                            class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                            Status Pembayaran</th>
                                        <th
                                            class="px-6 py-4 border-b border-slate-100 text-center font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @forelse ($transactions as $index => $transaction)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                                {{ $transactions->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 td-nowrap">
                                                {{ $transaction->created_at->translatedFormat('d M Y H:i') }}
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
                                                        class="btn btn-primary btn-icon btn-sm" title="Detail Transaksi">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                        class="btn btn-primary btn-icon btn-sm" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-icon btn-sm" title="Hapus"
                                                        onclick="confirmDelete('{{ $transaction->id }}')">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>

                                                    <!-- Delete Form -->
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
                                            <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-medium">
                                                Belum ada riwayat transaksi untuk pelanggan ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Section -->
                        @if ($transactions->hasPages())
                            <div class="border-t border-slate-100">
                                @include('dashboard.components.pagination', ['paginator' => $transactions])
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data transaksi ini akan dihapus secara permanen!",
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
