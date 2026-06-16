<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | CCTV Wongkito palembang</title>

    <!-- Meta SEO & CDN -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-16x16.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/form-plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome/css/all.css') }}">
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-600">
    <div class="h-screen w-full flex overflow-hidden">
        <!-- Left Banner Column -->
        <div class="hidden lg:flex lg:w-1/2 bg-brand-600 p-12 flex-col justify-between relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl">
            </div>
            <div
                class="absolute bottom-0 left-0 w-80 h-80 bg-white opacity-10 rounded-full translate-y-1/3 -translate-x-1/3 blur-3xl">
            </div>
            <!-- Logo -->
            <div class="relative z-10 flex items-center gap-3 font-semibold text-2xl text-white tracking-tight">
                <div class="flex items-center justify-center w-10 h-10 text-brand-600">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="AMPEDIG Logo"
                        class="h-10 w-auto rounded-xl">
                </div>
                <span>CCTV Wongkito</span>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 max-w-xl">
                <h2 class="text-5xl font-semibold mb-6 leading-tight text-white">Kelola Bisnis Digital Anda Lebih
                    Mudah.</h2>
                <p class="text-brand-100 text-lg leading-relaxed">Platform all-in-one untuk manajemen
                    agency dan transaksi PPOB yang efisien and modern.</p>
            </div>
            <div class="relative z-10 text-brand-200 text-sm font-medium">
                &copy; {{ date('Y') }} CCTV Wongkito. All rights reserved.
            </div>
        </div>

        <!-- Right Login Form Column -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center bg-white p-6 overflow-y-auto">
            <div class="w-full max-w-md ">
                <div class="lg:hidden flex justify-center mb-8">
                    <div class="flex items-center gap-2 font-semibold text-2xl text-slate-900">
                        <div class="flex items-center justify-center w-10 h-10 text-white">
                            <img src="{{ asset('assets/images/logo.webp') }}" alt="AMPEDIG Logo"
                                class="h-10 w-auto rounded-xl">
                        </div>
                        <span>CCTV Wongkito</span>
                    </div>
                </div>

                <!-- Header Form -->
                <div class="text-center lg:text-left mb-10">
                    <h1 class="text-3xl font-semibold text-slate-900 mb-3 tracking-tight">Selamat Datang</h1>
                    <p class="text-slate-500 text-lg">Masukan kredensial akun anda untuk melanjutkan.</p>
                </div>

                <!-- Session Status Alert -->
                @if (session('status'))
                    <div
                        class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Start -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700" for="email">Email Address</label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-brand-600">
                                <i class="fa-regular fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username" placeholder="nama@perusahaan.com"
                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all duration-200">
                        </div>
                        @error('email')
                            <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-semibold text-slate-700" for="password">Password</label>

                        </div>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-brand-600">
                                <i class="fa-solid fa-lock text-slate-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all duration-200">

                            <!-- Toggle Password Visibility -->
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors cursor-pointer focus:outline-none">
                                <i class="fa-regular fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" id="remember_me" name="remember"
                                    class="w-5 h-5 text-brand-600 border-slate-300 rounded focus:ring-brand-500 transition-colors cursor-pointer">
                                <span
                                    class="ml-3 text-sm text-slate-600 font-medium group-hover:text-slate-900 transition-colors">Ingat
                                    saya</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full btn btn-primary py-3.5 rounded-xl text-base shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5 transition-all duration-300">
                            Masuk ke Dashboard <i class="fa-solid fa-arrow-right ml-2 opacity-80"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Script for Password Toggle -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

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
    </script>
</body>

</html>
