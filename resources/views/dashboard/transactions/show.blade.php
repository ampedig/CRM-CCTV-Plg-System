@extends('dashboard.layouts.app')

@section('title', 'Detail Transaksi #' . $transaction->id)

@section('head')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .print-panel {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="flex-1 p-4 md:p-8">
        <div class="w-full">

            <!-- Page Header -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print">
                <div>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                        <a href="{{ route('transactions.index') }}"
                            class="hover:text-brand-600 transition-colors">Transaksi</a>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <span class="text-slate-700 font-semibold">#TRX-{{ sprintf('%04d', $transaction->id) }}</span>
                    </div>
                    <h2 class="text-2xl font-semibold text-slate-800">Detail Transaksi</h2>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="window.print()" class="btn btn-success btn-sm flex items-center gap-2">
                        <i class="fa-solid fa-print"></i> Print Struk
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-white btn-sm flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Single Panel -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 lg:p-8 space-y-8 print-panel">

                <!-- Header Struk -->
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-100">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-800">Invoice Transaksi</h3>
                        <p class="text-sm text-slate-500 mt-1">Diterbitkan pada
                            {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">No. Transaksi</p>
                        <p class="text-lg font-semibold text-slate-800">#TRX-{{ sprintf('%04d', $transaction->id) }}</p>
                        @if ($transaction->payment_status === 'paid')
                            <span
                                class="inline-block mt-2 px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Lunas</span>
                        @elseif ($transaction->payment_status === 'pending')
                            <span
                                class="inline-block mt-2 px-3 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                        @elseif ($transaction->payment_status === 'canceled')
                            <span
                                class="inline-block mt-2 px-3 py-1 rounded-lg text-xs font-semibold bg-red-100 text-red-700">Batal</span>
                        @endif
                    </div>
                </div>

                <!-- Info Pelanggan & Pembayaran -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-xl p-5">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Informasi Pelanggan
                        </p>
                        <div class="space-y-2">
                            <div class="flex gap-3">
                                <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                        class="fa-solid fa-user text-xs"></i></span>
                                <div>
                                    <p class="text-xs text-slate-400">Nama</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $transaction->customer?->full_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                        class="fa-solid fa-phone text-xs"></i></span>
                                <div>
                                    <p class="text-xs text-slate-400">No. WhatsApp</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $transaction->customer?->whatsapp_number ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                        class="fa-solid fa-location-dot text-xs"></i></span>
                                <div>
                                    <p class="text-xs text-slate-400">Pekerjaan</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $transaction->customer?->occupation ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-5">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Informasi Pembayaran
                        </p>
                        <div class="space-y-2">
                            <div class="flex gap-3">
                                <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                        class="fa-solid fa-calendar text-xs"></i></span>
                                <div>
                                    <p class="text-xs text-slate-400">Tanggal</p>
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $transaction->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-slate-400 w-5 mt-0.5 flex-shrink-0"><i
                                        class="fa-solid fa-circle-check text-xs"></i></span>
                                <div>
                                    <p class="text-xs text-slate-400">Status Pembayaran</p>
                                    @if ($transaction->payment_status === 'paid')
                                        <span
                                            class="inline-block mt-0.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-green-100 text-green-700">Lunas</span>
                                    @elseif ($transaction->payment_status === 'pending')
                                        <span
                                            class="inline-block mt-0.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                    @elseif ($transaction->payment_status === 'canceled')
                                        <span
                                            class="inline-block mt-0.5 px-2.5 py-0.5 rounded-md text-xs font-semibold bg-red-100 text-red-700">Batal
                                            / Gagal</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Produk -->
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Daftar Barang Yang Dibeli
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left min-w-[560px]">
                                <thead class="bg-slate-100/70 text-slate-500 text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="p-4 font-semibold">Produk</th>
                                        <th class="p-4 font-semibold text-right w-40">Harga Satuan</th>
                                        <th class="p-4 font-semibold text-center w-24">Qty</th>
                                        <th class="p-4 font-semibold text-right w-40">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white text-sm">
                                    @foreach ($transaction->details as $detail)
                                        @php
                                            $productImage = $detail->product->image
                                                ? asset('storage/' . $detail->product->image)
                                                : 'https://placehold.co/100x100/e2e8f0/64748b?text=' .
                                                    urlencode(substr($detail->product->name, 0, 3));
                                        @endphp
                                        <tr>
                                            <td class="p-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                                        <img src="{{ $productImage }}" alt="{{ $detail->product->name }}"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-slate-800">
                                                            {{ $detail->product->name }}</p>
                                                        <p class="text-xs text-slate-400">
                                                            {{ $detail->product->merk ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 text-right text-slate-600">Rp
                                                {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                            <td class="p-4 text-center text-slate-700 font-semibold">
                                                {{ $detail->quantity }}</td>
                                            <td class="p-4 text-right font-semibold text-slate-800">Rp
                                                {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals Footer -->
                        <div class="bg-slate-50 border-t border-slate-200 p-5">
                            <div class="flex justify-end">
                                <div class="w-full max-w-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-base font-semibold text-slate-800">Grand Total
                                            ({{ $transaction->details->sum('quantity') }} item)</span>
                                        <span class="text-2xl font-semibold text-brand-600">Rp
                                            {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Footer -->
                <div
                    class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 justify-between items-center no-print">
                    <a href="{{ route('transactions.index') }}"
                        class="btn btn-white flex items-center gap-2 order-2 sm:order-1">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <div class="flex gap-3 order-1 sm:order-2">
                        <button onclick="window.print()" class="btn btn-success flex items-center gap-2">
                            <i class="fa-solid fa-print"></i> Print Struk
                        </button>
                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                            class="btn btn-primary flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Transaksi
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
