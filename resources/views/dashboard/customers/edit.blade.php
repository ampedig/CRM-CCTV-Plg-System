@extends('dashboard.layouts.app')

@section('title', 'Edit Pelanggan')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white border border-slate-200 rounded-2xl p-8">

                    <div class="mb-8 pb-4 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800">Edit Pelanggan</h2>
                        <p class="text-sm text-slate-500 mt-1">Perbarui detail di bawah untuk data pelanggan ini.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span
                                    class="text-rose-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name', $customer->full_name) }}"
                                placeholder="Contoh: Rudi Hartono" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('full_name')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. WhatsApp <span
                                    class="text-rose-500">*</span></label>
                            <input type="tel" name="whatsapp_number"
                                value="{{ old('whatsapp_number', $customer->whatsapp_number) }}"
                                placeholder="Contoh: 081234567890" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('whatsapp_number')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan <span
                                    class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                            <input type="text" name="occupation" value="{{ old('occupation', $customer->occupation) }}"
                                placeholder="Contoh: Swasta, PNS, Pengusaha"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('occupation')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span
                                    class="text-slate-400 text-xs font-normal">(Opsional)</span>
                                <span id="age-display" class="text-xs text-brand-600 font-bold ml-2"></span>
                            </label>
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth', $customer->date_of_birth) }}"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700 text-left">
                            @error('date_of_birth')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pelanggan <span
                                    class="text-rose-500">*</span></label>
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div id="status-icon-bg"
                                        class="{{ old('is_active', $customer->is_active) ? 'p-2 bg-emerald-50 text-emerald-600' : 'p-2 bg-rose-50 text-rose-600' }} rounded-lg transition-colors duration-300">
                                        <i id="status-icon"
                                            class="fa-solid {{ old('is_active', $customer->is_active) ? 'fa-user-check' : 'fa-user-xmark' }}"></i>
                                    </div>
                                    <div>
                                        <p id="status-text"
                                            class="text-sm font-semibold text-slate-700 transition-colors duration-300">
                                            {{ old('is_active', $customer->is_active) ? 'Aktif' : 'Nonaktif' }}</p>
                                        <p id="status-desc" class="text-xs text-slate-500 transition-colors duration-300">
                                            {{ old('is_active', $customer->is_active) ? 'Pelanggan dapat melakukan transaksi dan menerima promo.' : 'Pelanggan dinonaktifkan sementara dan tidak dapat bertransaksi.' }}
                                        </p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" id="status-toggle" name="is_active" value="1"
                                        class="sr-only peer" {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                    <div id="toggle-bg"
                                        class="w-11 h-6 {{ old('is_active', $customer->is_active) ? 'bg-emerald-500' : 'bg-rose-500' }} peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all">
                                    </div>
                                </label>
                            </div>
                            @error('is_active')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Separator -->
                    <div class="mb-8 pb-4 border-b border-slate-100 mt-10">
                        <h2 class="text-lg font-semibold text-slate-800">
                            Advanced Updated
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Terdaftar (created_at)
                                <span class="text-rose-500">*</span></label>
                            <input type="date" name="created_at"
                                value="{{ old('created_at', $customer->created_at ? $customer->created_at->format('Y-m-d') : '') }}"
                                required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('created_at')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Total Chat Diterima <span
                                    class="text-rose-500">*</span></label>
                            <input type="number" name="total_chats_received"
                                value="{{ old('total_chats_received', $customer->total_chats_received) }}" min="0"
                                required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('total_chats_received')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Frekuensi Konsultasi <span
                                    class="text-rose-500">*</span></label>
                            <input type="number" name="consultation_frequency"
                                value="{{ old('consultation_frequency', $customer->consultation_frequency) }}"
                                min="0" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('consultation_frequency')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Kunjungan Web <span
                                    class="text-rose-500">*</span></label>
                            <input type="number" name="web_visit_count"
                                value="{{ old('web_visit_count', $customer->web_visit_count) }}" min="0" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('web_visit_count')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Transaksi (TRX) <span
                                    class="text-rose-500">*</span></label>
                            <input type="number" name="transaction_count"
                                value="{{ old('transaction_count', $customer->transaction_count) }}" min="0"
                                required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('transaction_count')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Total Nilai Transaksi (Rp) <span
                                    class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" name="total_transaction_value"
                                value="{{ old('total_transaction_value', $customer->total_transaction_value) }}"
                                min="0" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('total_transaction_value')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Minat Kategori Terakhir <span
                                    class="text-slate-400 text-xs font-normal">(Opsional)</span></label>
                            <input type="text" name="last_product_interest"
                                value="{{ old('last_product_interest', $customer->last_product_interest) }}"
                                placeholder="Contoh: Kamera CCTV, Aksesoris"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('last_product_interest')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pembayaran Global <span
                                    class="text-rose-500">*</span></label>
                            <select name="payment_status" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors font-medium text-slate-700">
                                <option value="Belum"
                                    {{ old('payment_status', $customer->payment_status) === 'Belum' ? 'selected' : '' }}>
                                    Belum Lunas (Belum)</option>
                                <option value="Lunas"
                                    {{ old('payment_status', $customer->payment_status) === 'Lunas' ? 'selected' : '' }}>
                                    Lunas</option>
                            </select>
                            @error('payment_status')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-white">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save"></i> Perbarui
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
                        statusIconBg.className =
                            'p-2 bg-emerald-50 text-emerald-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-rose-500');
                        toggleBg.classList.add('bg-emerald-500');
                    } else {
                        statusText.innerText = 'Nonaktif';
                        statusDesc.innerText =
                            'Pelanggan dinonaktifkan sementara dan tidak dapat bertransaksi.';
                        statusIcon.className = 'fa-solid fa-user-xmark';
                        statusIconBg.className =
                            'p-2 bg-rose-50 text-rose-600 rounded-lg transition-colors duration-300';
                        toggleBg.classList.remove('bg-emerald-500');
                        toggleBg.classList.add('bg-rose-500');
                    }
                };

                statusToggle.addEventListener('change', updateStatusView);
                updateStatusView(); // Run once on load
            }

            // Hitung Umur Otomatis
            const dobInput = document.getElementById('date_of_birth');
            const ageDisplay = document.getElementById('age-display');

            if (dobInput && ageDisplay) {
                const calculateAge = () => {
                    if (!dobInput.value) {
                        ageDisplay.innerText = '';
                        return;
                    }
                    const dob = new Date(dobInput.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const m = today.getMonth() - dob.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    ageDisplay.innerText = `(${age} Tahun)`;
                };

                dobInput.addEventListener('change', calculateAge);
                calculateAge(); // Run once on load
            }
        });
    </script>
@endsection
