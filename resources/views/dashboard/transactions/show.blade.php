@extends('dashboard.layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-800 mb-4">Detail Transaksi #{{ $transaction->id }}</h1>
            <p class="text-slate-500">Halaman rincian transaksi sedang dalam pengembangan.</p>
            <div class="mt-6">
                <a href="{{ route('transactions.index') }}" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Transaksi
                </a>
            </div>
        </div>
    </div>
@endsection
