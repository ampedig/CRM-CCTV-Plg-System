<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Keranjang Belanja - AMPEDIG",
    "description": "Simpan dan pesan produk CCTV pilihan Anda dari katalog AMPEDIG."
    })
    <style>
        /* Override body lock from form-plugins.css to allow scrolling */
        html,
        body {
            height: auto !important;
            overflow: auto !important;
            overscroll-behavior: auto !important;
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

        /* Cart image sizing */
        .cart-img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 1rem;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-700 min-h-screen flex flex-col">

    <!-- ===== STICKY NAVBAR ===== -->
    <header class="katalog-header sticky top-0 z-50 bg-white/90 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">

                <!-- Back Button -->
                <a href="katalog.html"
                    class="flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Katalog</span>
                </a>

                <!-- Logo -->
                <a href="katalog.html" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="../assets/images/logo.webp" alt="AMPEDIG" class="h-8 w-auto rounded-lg">
                    <span class="font-semibold text-lg text-slate-800 hidden sm:block">AMPEDIG</span>
                </a>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="btn btn-primary btn-sm flex items-center gap-2 rounded-xl">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== CART CONTAINER ===== -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
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
                        class="w-full py-4 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-2 mb-4">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Kirim Pesanan ke WhatsApp</span>
                    </a>

                    <a href="katalog.html"
                        class="w-full py-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 text-xs font-semibold rounded-xl text-center transition-colors">
                        Lanjut Belanja
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
            <a href="katalog.html" class="btn btn-primary px-8 py-3.5 rounded-xl text-xs font-semibold">
                Lihat Katalog Produk
            </a>
        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-800 text-slate-400 py-8 px-4 text-sm mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="../assets/images/logo.webp" alt="AMPEDIG" class="h-7 w-auto rounded-lg">
                <span class="font-semibold text-white">AMPEDIG</span>
            </div>
            <p>©
                <script>
                    document.write(new Date().getFullYear())
                </script> AMPEDIG. All rights reserved.
            </p>
        </div>
    </footer>

    @@include('../partials/vendor-scripts.html')

    <script>
        const WHATSAPP_NUMBER = '6281234567890';

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
                            <button onclick="updateQty(${index}, -1)" class="w-7 h-7 bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors">
                                <i class="fa-solid fa-minus text-[10px]"></i>
                            </button>
                            <span class="w-8 text-center text-xs font-semibold text-slate-700">${item.qty}</span>
                            <button onclick="updateQty(${index}, 1)" class="w-7 h-7 bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center text-sm font-semibold transition-colors">
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
            let waText = `Halo AMPEDIG 👋, saya ingin memesan beberapa produk dari katalog berikut:\n\n`;
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

</body>

</html>
