<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col nav-text-sm">

    <!-- Logo -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-slate-100 logo-wrapper">
        <div
            class="flex items-center gap-3 font-semibold text-lg tracking-tight text-slate-900 overflow-hidden logo-group">
            <img src="{{ asset('assets/images/logo.webp') }}" alt="AMPEDIG Logo" class="w-10 h-10 rounded-xl shrink-0">
            <span class="logo-text whitespace-nowrap">CCTV WK</span>
        </div>
        <button id="desktopSidebarToggle"
            class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors shrink-0 outline-none">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
    </div>

    <!-- Navigation Wrapper -->
    <div id="sidebarHoverArea" class="flex-1 flex flex-col min-h-0 overflow-hidden">
        <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto custom-scrollbar">

            <p class="sb-title t-sidebar-title">Main Menu</p>

            <a href="{{ route('dashboard') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-gauge-high sb-icon"></i>
                <span>Dashboard</span>
            </a>

            <p class="sb-title sb-title--spaced t-sidebar-title">Manajemen</p>

            <a href="{{ route('customers.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-users sb-icon"></i>
                <span>Pelanggan</span>
            </a>

            <a href="{{ route('products.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-cart-shopping sb-icon"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('categories.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-tag sb-icon"></i> <span>Kategori</span>
            </a>

            <a href="{{ route('transactions.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-receipt sb-icon"></i> <span>Transaksi</span>
            </a>

            <a href="{{ route('chat-histories.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-message sb-icon"></i> <span>Riwayat Chat</span>
            </a>

            <p class="sb-title sb-title--spaced t-sidebar-title">Admin</p>

            <a href="{{ route('users.index') }}" class="sb-item t-sidebar">
                <i class="fa-solid fa-users sb-icon"></i>
                <span>Pengguna</span>
            </a>

            <p class="sb-title sb-title--spaced t-sidebar-title">System</p>

            <a href="settings.html" class="sb-item t-sidebar">
                <i class="fa-solid fa-sliders sb-icon"></i>
                <span>Pengaturan</span>
            </a>

        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-slate-100">
            <a href="#" onclick="confirmLogout(event)" class="sb-logout t-sidebar">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden" style="display: none;">
                @csrf
            </form>
        </div>
    </div> <!-- Close Navigation Wrapper -->

</aside>

<style>
    /* Sidebar Collapse Transition & State */
    #sidebar {
        transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    /* Only apply collapsed visual state on desktop screens */
    @media (min-width: 1024px) {
        #sidebar.is-collapsed {
            width: 5.5rem;
            /* approx 88px */
        }

        #sidebar.is-collapsed .logo-text,
        #sidebar.is-collapsed .t-sidebar-title,
        #sidebar.is-collapsed .chevron-icon,
        #sidebar.is-collapsed .sb-item span,
        #sidebar.is-collapsed .sb-dropdown-content span,
        #sidebar.is-collapsed .sb-logout span,
        #sidebar.is-collapsed .submenu-container {
            display: none !important;
        }

        #sidebar.is-collapsed .logo-group {
            display: none !important;
        }

        #sidebar.is-collapsed .logo-wrapper {
            padding: 0;
            justify-content: center;
        }

        #sidebar.is-collapsed .sb-item,
        #sidebar.is-collapsed .sb-dropdown,
        #sidebar.is-collapsed .sb-logout {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #sidebar.is-collapsed .sb-dropdown-content {
            justify-content: center !important;
            width: 100%;
        }

        #sidebar.is-collapsed .sb-item i,
        #sidebar.is-collapsed .sb-dropdown-content i,
        #sidebar.is-collapsed .sb-logout i {
            margin-right: 0 !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('desktopSidebarToggle');

        if (sidebar && toggleBtn) {
            // Retrieve state from localStorage, default to true (pinned)
            let isPinned = localStorage.getItem('sidebarPinned') !== 'false';

            const updateIcon = () => {
                const icon = toggleBtn.querySelector('i');
                if (sidebar.classList.contains('is-collapsed')) {
                    icon.classList.remove('fa-bars-staggered');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-bars-staggered');
                }
            };

            // Initialize state on load
            if (!isPinned) {
                sidebar.classList.add('is-collapsed');
                updateIcon();
            }

            toggleBtn.addEventListener('click', () => {
                isPinned = !isPinned;
                localStorage.setItem('sidebarPinned', isPinned);
                if (isPinned) {
                    sidebar.classList.remove('is-collapsed');
                } else {
                    sidebar.classList.add('is-collapsed');
                }
                updateIcon();
            });

            const hoverArea = document.getElementById('sidebarHoverArea');
            if (hoverArea) {
                // Auto-expand on hover if it is currently collapsed (unpinned)
                hoverArea.addEventListener('mouseenter', () => {
                    if (!isPinned) {
                        sidebar.classList.remove('is-collapsed');
                        updateIcon();
                    }
                });

                // Auto-collapse on leave if it is unpinned
                hoverArea.addEventListener('mouseleave', () => {
                    if (!isPinned) {
                        sidebar.classList.add('is-collapsed');
                        updateIcon();
                    }
                });
            }
        }
    });

    function confirmLogout(event) {
        event.preventDefault();

        // Pastikan SweetAlert2 sudah dimuat, jika belum muat secara dinamis
        if (typeof Swal === 'undefined') {
            const script = document.createElement('script');
            script.src = "{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}";
            script.onload = () => showLogoutAlert();
            document.head.appendChild(script);
        } else {
            showLogoutAlert();
        }
    }

    function showLogoutAlert() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: "Apakah Anda yakin ingin keluar dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
