<!DOCTYPE html>
<html lang="id">

<head>
    @section('title', 'Keranjang Belanja - CCTV Palembang City')
    @include('dashboard.partials.head')

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Keranjang belanja produk kamera CCTV, DVR, IP Camera, dan aksesoris Anda di CCTV Palembang City. Selesaikan pemesanan Anda dengan mudah via WhatsApp.">
    <meta name="keywords" content="keranjang belanja cctv, cctv palembang city, beli cctv palembang, cctv palembang">
    <meta name="author" content="CCTV Palembang City">
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="Keranjang Belanja - CCTV Palembang City">
    <meta property="og:description"
        content="Keranjang belanja produk kamera CCTV, DVR, IP Camera, dan aksesoris Anda di CCTV Palembang City. Selesaikan pemesanan Anda dengan mudah via WhatsApp.">
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="Keranjang Belanja - CCTV Palembang City">
    <meta property="twitter:description"
        content="Keranjang belanja produk kamera CCTV, DVR, IP Camera, dan aksesoris Anda di CCTV Palembang City. Selesaikan pemesanan Anda dengan mudah via WhatsApp.">
    <meta property="twitter:image" content="{{ asset('assets/images/logo.png') }}">
    <style>
        /* Override body lock from form-plugins.css to allow scrolling */
        html {
            height: auto !important;
            overflow: auto !important;
            overscroll-behavior: auto !important;
        }

        /* Ensure footer sticks to bottom */
        body {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100vh !important;
            height: auto !important;
            overflow: auto !important;
            overscroll-behavior: auto !important;
            margin: 0;
        }

        /* Push footer to bottom */
        main {
            flex-grow: 1 !important;
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Sticky header blur */
        .katalog-header {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Custom max-width container to prevent excessive width on desktop */
        .katalog-container {
            max-width: 1080px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 640px) {
            .katalog-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .katalog-container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Fixed heights for logos to bypass missing Tailwind compilation */
        .katalog-logo {
            height: 32px !important;
            width: auto !important;
        }

        .katalog-logo-footer {
            height: 24px !important;
            width: auto !important;
        }

        /* Grid fallbacks for missing Tailwind classes */
        @media (min-width: 1024px) {
            .lg\:grid-cols-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }

            .lg\:col-span-8 {
                grid-column: span 8 / span 8 !important;
            }

            .lg\:col-span-4 {
                grid-column: span 4 / span 4 !important;
            }
        }

        /* Cart image sizing */
        .cart-img {
            width: 72px !important;
            height: 72px !important;
            object-fit: cover !important;
            border-radius: 1rem !important;
        }

        /* Fixed size for quantity buttons to prevent squishing */
        .cart-qty-btn {
            width: 28px !important;
            height: 28px !important;
            flex-shrink: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-700 min-h-screen flex flex-col">

    <!-- ===== STICKY NAVBAR ===== -->
    <header class="katalog-header sticky top-0 z-50 bg-white/90 border-b border-slate-100">
        <div class="katalog-container">
            <div class="flex items-center justify-between h-16 gap-4">

                <!-- Back Button -->
                <a href="{{ route('catalog.index') }}"
                    class="flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Katalog</span>
                </a>

                <!-- Logo -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="CCTV Palembang City"
                        class="katalog-logo rounded-lg">
                    <span class="font-semibold text-lg text-slate-800 hidden sm:block">CCTV Palembang City</span>
                </a>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank"
                        class="btn btn-primary btn-sm flex items-center gap-2 rounded-xl">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== CART CONTAINER ===== -->
    <main class="flex-grow katalog-container py-10 w-full">
        <h1 class="text-xl sm:text-2xl font-semibold text-slate-800 mb-8">Keranjang Belanja</h1>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" id="cartContent">

            <!-- Left Column: Items List -->
            <div class="lg:col-span-8 flex flex-col gap-4" id="cartItemsList">
                <!-- Javascript will populate the items here -->
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-4" id="cartSummaryBox">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col">
                    <h2 class="text-base font-semibold text-slate-800 mb-4 pb-4 border-b border-slate-100">Ringkasan
                        Pesanan</h2>

                    <div class="flex justify-between text-sm mb-3">
                        <span class="text-slate-400">Total Item</span>
                        <span id="summaryTotalItems" class="text-slate-700 font-semibold">0</span>
                    </div>

                    <div class="flex justify-between text-base mb-6 pt-3 border-t border-slate-100/80">
                        <span class="text-slate-800 font-semibold">Estimasi Total</span>
                        <span id="summaryTotalPrice" class="text-brand-600 font-semibold text-lg">Rp 0</span>
                    </div>

                    <a id="checkoutWaBtn" href="#" target="_blank"
                        class="btn btn-primary w-full rounded-xl flex items-center justify-center gap-2 mb-4">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Kirim Pesanan ke WhatsApp</span>
                    </a>

                    <a href="{{ route('catalog.index') }}"
                        class="btn btn-white w-full rounded-xl flex items-center justify-center gap-2">
                        <span>Lanjut Belanja</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Empty Cart State -->
        <div id="emptyCart"
            class="hidden text-center py-24 bg-white border border-slate-200 rounded-3xl p-8 max-w-2xl mx-auto">
            <div class="text-6xl mb-6">🛒</div>
            <h2 class="text-lg font-semibold text-slate-700 mb-2">Keranjang Belanja Kosong</h2>
            <p class="text-sm text-slate-400 mb-6 max-w-md mx-auto">Anda belum menambahkan produk apa pun ke keranjang
                belanja Anda. Temukan berbagai solusi CCTV terbaik di katalog kami.</p>
            <a href="{{ route('catalog.index') }}"
                class="btn btn-primary rounded-xl inline-flex items-center justify-center px-8">
                Lihat Katalog Produk
            </a>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-800 text-slate-400 py-8 px-4 text-sm mt-auto">
        <div class="katalog-container flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="CCTV Palembang City"
                    class="katalog-logo-footer rounded-lg">
                <span class="font-semibold text-white">CCTV Palembang City</span>
            </div>
            <p>©
                <script>
                    document.write(new Date().getFullYear())
                </script> CCTV Palembang City. All rights reserved.
            </p>
        </div>
    </footer>

    @include('dashboard.partials.vendor-scripts')

    <script>
        const WHATSAPP_NUMBER = '{{ config('services.whatsapp.number') }}';

        // Load items from localStorage
        function getCart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }

        // Save items to localStorage
        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }

        // Format IDR Currency
        function formatPrice(val) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(val);
        }

        // Render Cart Layout
        function renderCart() {
            const cart = getCart();
            const listContainer = document.getElementById('cartItemsList');
            const contentContainer = document.getElementById('cartContent');
            const emptyContainer = document.getElementById('emptyCart');

            if (cart.length === 0) {
                contentContainer.classList.add('hidden');
                emptyContainer.classList.remove('hidden');
                return;
            }

            contentContainer.classList.remove('hidden');
            emptyContainer.classList.add('hidden');

            // Render list
            listContainer.innerHTML = cart.map((item, index) => `
                <div class="bg-white border border-slate-200 rounded-3xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        <img src="${item.img}" alt="${item.name}" class="cart-img border border-slate-100 flex-shrink-0">
                        <div class="flex-1">
                            <span class="text-[10px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md w-fit inline-block mb-1 capitalize">${item.brand}</span>
                            <h3 class="text-sm font-semibold text-slate-800 leading-snug mb-1">${item.name}</h3>
                            <p class="text-xs text-slate-400 font-medium">Harga: ${formatPrice(item.price)} / ${item.unit}</p>
                        </div>
                    </div>

                    <!-- Quantity Control & Price -->
                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
                        <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-2 py-1">
                            <button onclick="updateQty(${index}, -1)" class="cart-qty-btn bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 rounded-lg text-sm font-semibold transition-colors">
                                <i class="fa-solid fa-minus text-[10px]"></i>
                            </button>
                            <span class="w-8 text-center text-xs font-semibold text-slate-700">${item.qty}</span>
                            <button onclick="updateQty(${index}, 1)" class="cart-qty-btn bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 rounded-lg text-sm font-semibold transition-colors">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </button>
                        </div>

                        <div class="text-right flex-shrink-0 min-w-[100px]">
                            <p class="text-xs text-slate-400 font-semibold mb-0.5">Subtotal</p>
                            <p class="text-sm font-semibold text-slate-800">${formatPrice(item.price * item.qty)}</p>
                        </div>

                        <button onclick="removeItem(${index})" class="text-slate-400 hover:text-rose-500 transition-colors p-2" title="Hapus produk">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            // Recalculate summary details
            const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
            const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

            document.getElementById('summaryTotalItems').innerText = `${totalItems} unit`;
            document.getElementById('summaryTotalPrice').innerText = formatPrice(totalPrice);

            // Construct WhatsApp Message
            let waText = `Halo CCTV Palembang City 👋, saya ingin memesan beberapa produk dari katalog berikut:\n\n`;
            cart.forEach((item, i) => {
                waText +=
                    `${i + 1}. *${item.name}*\n   (${item.qty} ${item.unit}) x ${formatPrice(item.price)} = *${formatPrice(item.price * item.qty)}*\n\n`;
            });
            waText +=
                `*Estimasi Total Pesanan: ${formatPrice(totalPrice)}*\n\nMohon dibantu info ketersediaan stok & proses kelanjutannya. Terima kasih!`;

            document.getElementById('checkoutWaBtn').href =
                `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(waText)}`;
        }

        // Adjust Quantity
        function updateQty(index, dir) {
            const cart = getCart();
            cart[index].qty += dir;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            saveCart(cart);
        }

        // Delete Item
        function removeItem(index) {
            const cart = getCart();
            cart.splice(index, 1);
            saveCart(cart);
        }

        // Initial render on load
        window.addEventListener('DOMContentLoaded', renderCart);
    </script>

    @include('catalog.partials.user-tracker')
</body>

</html>
