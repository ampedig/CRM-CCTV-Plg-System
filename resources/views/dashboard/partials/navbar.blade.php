<header
    class="flex items-center justify-between px-8 h-20 bg-white border-b border-slate-200 sticky top-0 z-20 shrink-0">
    <div class="flex items-center gap-4">
        <button id="sidebarToggle" class="p-2 -ml-2 text-slate-500 lg:hidden rounded-lg hover:bg-slate-50">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <form action="{{ url()->current() }}" method="GET" class="hidden md:flex items-center relative group">
            @if (request()->has('per_page'))
                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
            @endif
            <i
                class="fa-solid fa-magnifying-glass absolute left-4 text-slate-400 text-sm group-focus-within:text-brand-500 transition-colors"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                class="pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 rounded-2xl text-sm text-slate-700 w-80 transition-all placeholder-slate-400 font-medium">
        </form>
    </div>

    <div class="flex items-center gap-3">
        <button id="themeToggle"
            class="p-2.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-all hidden md:block"
            title="Ganti Tema">
            <i class="fa-solid fa-palette"></i>
        </button>

        <button id="fullscreenToggle"
            class="p-2.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-all hidden md:block"
            title="Toggle Fullscreen">
            <i id="fullscreenIcon" class="fa-solid fa-expand"></i>
        </button>
        <div class="h-8 w-px bg-slate-200 mx-2 hidden md:block"></div>
        <a href="profil.html" class="flex items-center gap-3 hover:bg-slate-50 p-1.5 pr-2 rounded-xl transition-colors">
            <div class="text-right hidden md:block">
                <p class="text-sm font-semibold text-slate-900">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs font-medium text-brand-600">
                    @if (Auth::user()->role == 'admin')
                        Admin
                    @elseif (Auth::user()->role == 'sales')
                        Penjual
                    @endif
                </p>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=2563eb&color=fff&bold=true"
                class="w-10 h-10 rounded-full border-2 border-white shadow-sm hover:opacity-90 transition">
        </a>
    </div>
</header>

<!-- Theme Modal -->
<div id="themeModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <!-- Backdrop -->
    <div
        class="modal-backdrop fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 modal-backdrop-click-area">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto modal-backdrop-click-area">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0 modal-backdrop-click-area">

            <!-- Modal Panel -->
            <div
                class="modal-content relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all duration-300 sm:my-8 sm:w-full sm:max-w-lg scale-95 opacity-0">

                <!-- Header -->
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold leading-6 text-slate-900" id="modal-title">Pilih Tema Tampilan
                        </h3>
                        <button id="themeClose" class="text-slate-400 hover:text-slate-500 transition-colors">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Sesuaikan tampilan dashboard dengan warna favorit Anda.</p>
                </div>

                <!-- Body -->
                <div class="bg-white px-4 py-6 sm:p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Blue (Default) -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="default">
                            <div
                                class="h-24 rounded-xl bg-slate-50 relative overflow-hidden border border-slate-200 group-hover:border-blue-300 transition-all">
                                <!-- Checkmark Overlay -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-white/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI Mockup -->
                                <div class="absolute left-0 top-0 bottom-0 w-[24px] bg-white border-r border-slate-200">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-white border-b border-slate-200"></div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div class="bg-white rounded-md p-1.5 shadow-sm border border-slate-100 mb-2">
                                        <div class="h-1.5 w-10 bg-blue-500 rounded-full mb-1.5"></div>
                                        <div class="flex gap-1">
                                            <div class="h-4 w-full bg-blue-50 rounded"></div>
                                            <div class="h-4 w-3/4 bg-indigo-50 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="flex gap-1.5">
                                        <div class="h-6 w-full bg-blue-100 rounded-md"></div>
                                        <div class="h-6 w-full bg-slate-100 rounded-md"></div>
                                    </div>
                                    <!-- Decorative -->
                                    <div
                                        class="absolute -bottom-4 -right-4 w-12 h-12 bg-blue-500/20 blur-xl rounded-full">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Royal Ocean</p>
                            <p class="text-center text-xs text-slate-500">Blue & Indigo</p>
                        </div>

                        <!-- Purple -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="purple">
                            <div
                                class="h-24 rounded-xl bg-slate-50 relative overflow-hidden border border-slate-200 group-hover:border-purple-300 transition-all">
                                <!-- Checkmark -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-white/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI -->
                                <div class="absolute left-0 top-0 bottom-0 w-[24px] bg-white border-r border-slate-200">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-white border-b border-slate-200"></div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div class="flex gap-2 mb-2">
                                        <div
                                            class="w-8 h-8 rounded-full border-2 border-purple-500 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                        </div>
                                        <div class="flex-1 space-y-1 py-1">
                                            <div class="h-1.5 bg-purple-200 rounded w-3/4"></div>
                                            <div class="h-1.5 bg-slate-100 rounded w-1/2"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="h-6 w-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-md opacity-80">
                                    </div>
                                    <div
                                        class="absolute -bottom-4 -right-4 w-12 h-12 bg-purple-500/20 blur-xl rounded-full">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Mystic Berry</p>
                            <p class="text-center text-xs text-slate-500">Purple & Pink</p>
                        </div>

                        <!-- Emerald -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="emerald">
                            <div
                                class="h-24 rounded-xl bg-slate-50 relative overflow-hidden border border-slate-200 group-hover:border-emerald-300 transition-all">
                                <!-- Checkmark -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-white/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI -->
                                <div class="absolute left-0 top-0 bottom-0 w-[24px] bg-white border-r border-slate-200">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-white border-b border-slate-200">
                                </div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div class="bg-white rounded-md p-1.5 shadow-sm border border-slate-100 mb-1.5">
                                        <div class="flex items-end gap-1 h-5">
                                            <div class="w-1/4 bg-emerald-200 h-3/4 rounded-[1px]"></div>
                                            <div class="w-1/4 bg-emerald-300 h-1/2 rounded-[1px]"></div>
                                            <div class="w-1/4 bg-emerald-500 h-full rounded-[1px]"></div>
                                            <div class="w-1/4 bg-emerald-200 h-2/3 rounded-[1px]"></div>
                                        </div>
                                    </div>
                                    <div class="h-5 w-full bg-emerald-50 rounded-md border border-emerald-100"></div>
                                    <div
                                        class="absolute -bottom-4 -right-4 w-12 h-12 bg-emerald-500/20 blur-xl rounded-full">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Lush Forest</p>
                            <p class="text-center text-xs text-slate-500">Emerald & Lime</p>
                        </div>

                        <!-- Orange -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="orange">
                            <div
                                class="h-24 rounded-xl bg-slate-50 relative overflow-hidden border border-slate-200 group-hover:border-orange-300 transition-all">
                                <!-- Checkmark -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-white/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-orange-600 text-white flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI -->
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-[24px] bg-white border-r border-slate-200">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-white border-b border-slate-200">
                                </div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div class="grid grid-cols-2 gap-2 mb-2">
                                        <div class="bg-orange-100 rounded-md h-8 border border-orange-200"></div>
                                        <div class="bg-white rounded-md h-8 border border-slate-100 shadow-sm p-1">
                                            <div class="w-3 h-3 rounded-full bg-orange-500 mb-1"></div>
                                            <div class="w-full h-1 bg-slate-100 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="h-4 w-3/4 bg-orange-500 rounded-sm opacity-90"></div>
                                    <div
                                        class="absolute -bottom-4 -right-4 w-12 h-12 bg-orange-500/20 blur-xl rounded-full">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Sunset Glow</p>
                            <p class="text-center text-xs text-slate-500">Orange & Red</p>
                        </div>

                        <!-- Pink -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="pink">
                            <div
                                class="h-24 rounded-xl bg-slate-50 relative overflow-hidden border border-slate-200 group-hover:border-pink-300 transition-all">
                                <!-- Checkmark -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-white/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI -->
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-[24px] bg-white border-r border-slate-200">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-white border-b border-slate-200">
                                </div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div
                                        class="bg-white rounded-md border border-slate-100 shadow-sm p-1.5 mb-2 relative overflow-hidden">
                                        <div class="absolute -right-2 -top-2 w-6 h-6 bg-pink-100 rounded-full"></div>
                                        <div class="h-1.5 w-8 bg-pink-500 rounded-full mb-1"></div>
                                        <div class="h-1 w-full bg-slate-100 rounded-full"></div>
                                    </div>
                                    <div class="flex gap-1.5 items-center">
                                        <div
                                            class="w-6 h-6 rounded-full bg-pink-100 border border-pink-200 flex items-center justify-center">
                                            <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                        </div>
                                        <div class="flex-1 h-2 bg-slate-100 rounded-full"></div>
                                    </div>
                                    <div
                                        class="absolute -bottom-4 -right-4 w-12 h-12 bg-pink-500/20 blur-xl rounded-full">
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Neon Rose</p>
                            <p class="text-center text-xs text-slate-500">Pink & Purple</p>
                        </div>

                        <!-- Black -->
                        <div class="theme-option cursor-pointer group p-3 rounded-2xl hover:bg-slate-50 transition-all"
                            data-value="black">
                            <div
                                class="h-24 rounded-xl bg-slate-900 relative overflow-hidden border border-slate-700 group-hover:border-slate-500 transition-all">
                                <!-- Checkmark -->
                                <div
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-black/30 backdrop-blur-[1px] opacity-0 group-[.ring-2]:opacity-100 transition-opacity">
                                    <div
                                        class="w-8 h-8 rounded-full bg-white text-slate-900 flex items-center justify-center shadow-lg transform scale-75 group-[.ring-2]:scale-100 transition-transform">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                </div>
                                <!-- UI Dark Mode -->
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-[24px] bg-slate-800 border-r border-slate-700">
                                </div>
                                <div class="absolute left-0 top-0 right-0 h-3 bg-slate-800 border-b border-slate-700">
                                </div>
                                <!-- Content -->
                                <div class="absolute inset-0 pt-5 pl-[30px] pr-2">
                                    <div class="bg-slate-800 rounded-md border border-slate-700 p-1.5 mb-2">
                                        <div class="h-1.5 w-10 bg-slate-500 rounded-full mb-1.5"></div>
                                        <div class="h-4 w-full bg-slate-700 rounded-sm"></div>
                                    </div>
                                    <div class="h-6 w-full bg-slate-800 rounded-md border border-slate-700"></div>
                                </div>
                            </div>
                            <p class="mt-3 text-center text-sm font-semibold text-slate-700">Midnight</p>
                            <p class="text-center text-xs text-slate-500">Slate & Gray</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                    <button type="button" class="btn btn-primary w-full sm:w-auto sm:ml-3"
                        onclick="document.getElementById('themeClose').click()">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</div>
