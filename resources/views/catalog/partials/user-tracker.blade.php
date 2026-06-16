{{-- User Tracker Modal Component --}}
<div id="trackerModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-md transition-opacity duration-300 opacity-0" id="trackerBackdrop" onclick="closeTrackerModal()"></div>
    
    <!-- Modal Card -->
    <div class="bg-white rounded-3xl max-w-md w-full border border-slate-100 shadow-2xl overflow-hidden relative transform transition-all scale-95 duration-300 opacity-0 z-10" id="trackerCard">
        <!-- Close Button -->
        <button onclick="closeTrackerModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors p-2 rounded-full hover:bg-slate-50">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <!-- Step 1: Input WhatsApp -->
        <div id="stepPhone" class="p-6 sm:p-8 flex flex-col items-center text-center">
            <!-- Icon -->
            <div class="w-16 h-16 bg-brand-50 rounded-2xl flex items-center justify-center text-brand-600 mb-6 border border-brand-100">
                <i class="fa-brands fa-whatsapp text-3xl"></i>
            </div>
            
            <h3 class="text-xl font-bold text-slate-800 mb-2">Verifikasi WhatsApp</h3>
            <p class="text-slate-400 text-sm mb-6 max-w-sm">Masukkan nomor WhatsApp Anda untuk melanjutkan dan mendapatkan info promo serta tracking pesanan yang personal.</p>

            <form id="formPhone" class="w-full text-left" onsubmit="handlePhoneSubmit(event)">
                <div class="mb-4">
                    <label for="inputWa" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm font-semibold">+62</span>
                        </div>
                        <input type="text" id="inputWa" placeholder="81234567890" 
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold"
                            required>
                    </div>
                    <p id="errorPhone" class="text-xs text-rose-500 mt-1.5 hidden"></p>
                </div>

                <div class="flex flex-col gap-2.5 mt-6">
                    <button type="submit" id="btnPhoneSubmit" class="btn btn-primary w-full py-3 rounded-xl flex items-center justify-center gap-2 font-semibold">
                        <span>Lanjutkan</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                    <button type="button" onclick="closeTrackerModal()" class="w-full py-2.5 text-xs text-slate-400 hover:text-slate-600 font-semibold transition-colors text-center">
                        Nanti Saja
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Register New Customer -->
        <div id="stepRegister" class="p-6 sm:p-8 hidden">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-4 border border-blue-100">
                    <i class="fa-solid fa-user-plus text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Lengkapi Profil Anda</h3>
                <p class="text-slate-400 text-xs max-w-xs">Nomor Anda belum terdaftar. Yuk, lengkapi profil singkat Anda untuk proses transaksi yang lebih cepat.</p>
            </div>

            <form id="formRegister" class="text-left" onsubmit="handleRegisterSubmit(event)">
                <!-- Phone (Display Only) -->
                <div class="mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nomor WhatsApp</label>
                    <div class="px-4 py-2.5 bg-slate-50 border border-slate-100 rounded-xl text-slate-600 text-sm font-semibold flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                        <span id="displayWa"></span>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="inputName" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="inputName" placeholder="Masukkan nama lengkap" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold"
                        required>
                </div>

                <!-- Pekerjaan -->
                <div class="mb-4">
                    <label for="inputOccupation" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Pekerjaan</label>
                    <input type="text" id="inputOccupation" placeholder="Contoh: Pengusaha, Karyawan" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold">
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-5">
                    <label for="inputDob" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Tanggal Lahir</label>
                    <input type="date" id="inputDob" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:bg-white transition-all font-semibold">
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="goToStepPhone()" class="btn btn-white flex-1 py-2.5 rounded-xl text-xs font-semibold">
                        Kembali
                    </button>
                    <button type="submit" id="btnRegisterSubmit" class="btn btn-primary flex-[2] py-2.5 rounded-xl text-xs font-semibold flex items-center justify-center gap-1.5">
                        <span>Daftar & Simpan</span>
                        <i class="fa-solid fa-check text-xs"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let tempWaNumber = '';

    // Initialize checking on DOM Content Loaded
    document.addEventListener('DOMContentLoaded', () => {
        const customerWa = localStorage.getItem('customer_wa');
        if (!customerWa) {
            // Delay modal slightly for better UX
            setTimeout(showTrackerModal, 1500);
        } else {
            // Check session visit interval (4 hours limit)
            const lastAccess = localStorage.getItem('customer_last_access');
            const now = new Date().getTime();
            const fourHours = 4 * 60 * 60 * 1000;

            if (!lastAccess || (now - parseInt(lastAccess)) > fourHours) {
                recordVisit(customerWa);
            }
        }
    });

    function showTrackerModal() {
        const modal = document.getElementById('trackerModal');
        const backdrop = document.getElementById('trackerBackdrop');
        const card = document.getElementById('trackerCard');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Force reflow for transitions
        void modal.offsetWidth;

        backdrop.classList.remove('opacity-0');
        backdrop.classList.add('opacity-100');

        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
    }

    function closeTrackerModal() {
        const modal = document.getElementById('trackerModal');
        const backdrop = document.getElementById('trackerBackdrop');
        const card = document.getElementById('trackerCard');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');

        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    function goToStepPhone() {
        document.getElementById('stepRegister').classList.add('hidden');
        document.getElementById('stepPhone').classList.remove('hidden');
    }

    function goToStepRegister(wa) {
        document.getElementById('stepPhone').classList.add('hidden');
        document.getElementById('displayWa').innerText = '+' + wa;
        document.getElementById('stepRegister').classList.remove('hidden');
    }

    // Normalized formatted output input
    function getNormalizedWaInput() {
        let input = document.getElementById('inputWa').value.trim();
        // Remove spaces, dashes, parentheses
        input = input.replace(/\D/g, '');
        
        // Remove leading 62 or 0
        if (input.startsWith('0')) {
            input = input.substring(1);
        } else if (input.startsWith('62')) {
            input = input.substring(2);
        }
        
        return '62' + input;
    }

    // Step 1: Submit Phone Number
    async function handlePhoneSubmit(e) {
        e.preventDefault();
        const errorEl = document.getElementById('errorPhone');
        const btn = document.getElementById('btnPhoneSubmit');
        errorEl.classList.add('hidden');
        
        const rawInput = document.getElementById('inputWa').value.trim();
        if (!rawInput) {
            errorEl.innerText = 'Nomor WhatsApp wajib diisi.';
            errorEl.classList.remove('hidden');
            return;
        }

        const normalizedWa = getNormalizedWaInput();
        tempWaNumber = normalizedWa;

        // Disable button & show loading state
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> <span>Memproses...</span>`;

        try {
            const response = await fetch("{{ route('catalog.tracker.check') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ whatsapp_number: normalizedWa })
            });

            const result = await response.json();
            
            if (result.exists) {
                // User exists -> Save to local storage & record visit
                localStorage.setItem('customer_wa', result.whatsapp_number);
                localStorage.setItem('customer_last_access', new Date().getTime().toString());
                
                // Record visit counts
                await recordVisit(result.whatsapp_number);
                closeTrackerModal();
            } else {
                // User does not exist -> Proceed to Registration form
                goToStepRegister(result.whatsapp_number);
            }
        } catch (error) {
            console.error("Error checking customer WA:", error);
            errorEl.innerText = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
            errorEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }
    }

    // Step 2: Submit Registration Form
    async function handleRegisterSubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('btnRegisterSubmit');
        
        const name = document.getElementById('inputName').value.trim();
        const occupation = document.getElementById('inputOccupation').value.trim();
        const dob = document.getElementById('inputDob').value;

        if (!name) return;

        // Disable button
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> <span>Mendaftarkan...</span>`;

        try {
            const response = await fetch("{{ route('catalog.tracker.register') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    whatsapp_number: tempWaNumber,
                    full_name: name,
                    occupation: occupation,
                    date_of_birth: dob
                })
            });

            const result = await response.json();
            
            if (result.success) {
                localStorage.setItem('customer_wa', result.whatsapp_number);
                localStorage.setItem('customer_last_access', new Date().getTime().toString());
                closeTrackerModal();
            }
        } catch (error) {
            console.error("Error registering customer:", error);
            alert('Terjadi kesalahan koneksi saat pendaftaran.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }
    }

    // Record Visit Helper
    async function recordVisit(wa) {
        try {
            const response = await fetch("{{ route('catalog.tracker.visit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ whatsapp_number: wa })
            });
            const result = await response.json();
            if (result.success) {
                localStorage.setItem('customer_last_access', new Date().getTime().toString());
            }
        } catch (error) {
            console.error("Error recording visit count:", error);
        }
    }
</script>
