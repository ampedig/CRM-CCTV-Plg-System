@extends('dashboard.layouts.app')

@section('title', 'Edit Pengguna')

@section('head')
    <!-- Select2 CSS (Local) -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <!-- Form Container (Single Component) -->
        <div class="max-w-screen-2xl mx-auto">

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Wrapper Card Putih Besar -->
                <div class="bg-white border border-slate-200 rounded-2xl p-8">

                    <!-- Header Kecil dalam Form -->
                    <div class="mb-8 pb-4 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-800">Edit Pengguna</h2>
                        <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk memperbarui data pengguna.</p>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap
                                <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Contoh: Ahmad Fauzi"
                                required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('name')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Email -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email
                                <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="Contoh: ahmad.fauzi@example.com" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                            @error('email')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kata Sandi -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi (Opsional)</label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah password"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                <button type="button" onclick="togglePasswordVisibility()"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                    <i class="fa-solid fa-eye" id="password-toggle-icon"></i>
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Biarkan kosong jika tidak ingin memperbarui password pengguna.</p>
                            @error('password')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="w-full">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Role <span
                                    class="text-rose-500">*</span></label>
                            <select class="select2-role w-full" required name="role">
                                <option></option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="sales" {{ old('role', $user->role) === 'sales' ? 'selected' : '' }}>Sales</option>
                            </select>
                            @error('role')
                                <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                        <a href="{{ route('users.index') }}" class="btn btn-white">
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
    <!-- Select2 JS (Local) -->
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- Page Specific Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Select2 Initialization (Fixed Width) ---
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-role').select2({
                    placeholder: 'Pilih Role',
                    width: '100%',
                    minimumResultsForSearch: Infinity
                });
            }
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle-icon');
            if (passwordInput && toggleIcon) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        }
    </script>
@endsection
