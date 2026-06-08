@extends('dashboard.layouts.app')

@section('title', 'Tambah Pelanggan')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="bg-white border border-slate-200 rounded-2xl p-8">

                    <div class="mb-8 pb-4 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800">Tambah Pelanggan Baru</h2>
                        <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk mendaftarkan pelanggan baru.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Contoh: Rudi Hartono" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('full_name')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp <span class="text-rose-500">*</span></label>
                            <input type="tel" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 081234567890" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('whatsapp_number')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan <span class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                            <input type="text" name="occupation" value="{{ old('occupation') }}" placeholder="Contoh: Swasta, PNS, Pengusaha" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('occupation')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700 text-left">
                            @error('date_of_birth')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pelanggan <span class="text-rose-500">*</span></label>
                            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div id="status-icon-bg" class="{{ old('is_active', 1) ? 'p-2 bg-emerald-50 text-emerald-600' : 'p-2 bg-rose-50 text-rose-600' }} rounded-lg transition-colors duration-300">
                                        <i id="status-icon" class="fa-solid {{ old('is_active', 1) ? 'fa-user-check' : 'fa-user-xmark' }}"></i>
                                    </div>
                                    <div>
                                        <p id="status-text" class="text-sm font-semibold text-slate-700 transition-colors duration-300">{{ old('is_active', 1) ? 'Aktif' : 'Nonaktif' }}</p>
                                        <p id="status-desc" class="text-xs text-slate-500 transition-colors duration-300">
                                            {{ old('is_active', 1) ? 'Pelanggan dapat melakukan transaksi dan menerima promo.' : 'Pelanggan dinonaktifkan sementara dan tidak dapat bertransaksi.' }}
                                        </p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" id="status-toggle" name="is_active" value="1" class="sr-only peer" {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <div id="toggle-bg" class="w-11 h-6 {{ old('is_active', 1) ? 'bg-emerald-500' : 'bg-rose-500' }} peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all">
                                    </div>
                                </label>
                            </div>
                            @error('is_active')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-white">
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
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                        statusDesc.innerText = 'Pelanggan dapat melakukan transaksi dan menerima promo.';
                        statusIcon.className = 'fa-solid fa-user-check';
                        statusIconBg.className = 'p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-rose-500');
                        toggleBg.classList.add('bg-emerald-500');
                    } else {
                        statusText.innerText = 'Nonaktif';
                        statusDesc.innerText = 'Pelanggan dinonaktifkan sementara dan tidak dapat bertransaksi.';
                        statusIcon.className = 'fa-solid fa-user-xmark';
                        statusIconBg.className = 'p-2 bg-rose-50 text-rose-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-emerald-500');
                        toggleBg.classList.add('bg-rose-500');
                    }
                };

                statusToggle.addEventListener('change', updateStatusView);
                updateStatusView(); // Run once on load
            }
        });
    </script>
@endsection
