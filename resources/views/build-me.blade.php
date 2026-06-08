<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Tambah Pengguna - Masum.xyz",
    "description": "Halaman Tambah Pengguna Baru"
    })
    <!-- Select2 CSS (Local) -->
    <link rel="stylesheet" href="assets/libs/select2/css/select2.min.css">
</head>

<body class="bg-slate-50 text-slate-600 font-sans antialiased">

    <div class="fixed inset-0 flex overflow-hidden bg-slate-50">

        @@include('../partials/sidebar.html')

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/20 z-40 hidden lg:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

            @@include('../partials/navbar.html')

            <!-- Scrollable Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">

                <!-- Content Wrapper -->
                <div class="flex-1 p-8">
                    <!-- Form Container (Single Component) -->
                    <div class="max-w-screen-2xl mx-auto">

                        <form action="javascript:void(0)" method="POST">
                            <!-- Wrapper Card Putih Besar -->
                            <div class="bg-white border border-slate-200 rounded-2xl p-8">

                                <!-- Header Kecil dalam Form -->
                                <div class="mb-8 pb-4 border-b border-slate-100">
                                    <h2 class="text-lg font-semibold text-slate-800">Tambah Pengguna Baru</h2>
                                    <p class="text-sm text-slate-500 mt-1">Lengkapi detail di bawah untuk menambahkan
                                        pengguna baru.
                                    </p>
                                </div>

                                <!-- Form Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" placeholder="Contoh: Ahmad Fauzi"
                                            required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email
                                            <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            placeholder="Contoh: ahmad.fauzi@example.com" required
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi <span
                                                class="text-danger">*</span></label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                placeholder="Minimal 8 karakter" required
                                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors placeholder-slate-400 font-medium text-slate-700">
                                            <button type="button" onclick="togglePasswordVisibility()"
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                                <i class="fa-solid fa-eye" id="password-toggle-icon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Role <span
                                                class="text-danger">*</span></label>
                                        <select class="select2-role w-full" required name="role">
                                            <option></option>
                                            <option value="admin">Admin</option>
                                            <option value="sales">Sales</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Action Buttons (Bottom Left Aligned) -->
                                <div class="pt-6 border-t border-slate-100 flex items-center justify-start gap-3">
                                    <a href="pengguna.html" class="btn btn-white">
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

                @@include('../partials/footer.html')
            </main>
        </div>
    </div>

    @@include('../partials/vendor-scripts.html')

    <!-- Page Specific Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Select2 Initialization (Fixed Width) ---
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-role').select2({
                    placeholder: 'Pilih Role',
                    width: '100%', // Memaksa width 100% dari container parent
                    minimumResultsForSearch: Infinity // Sembunyikan search jika item sedikit
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
</body>

</html>
