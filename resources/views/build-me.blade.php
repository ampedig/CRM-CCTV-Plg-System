<!DOCTYPE html>
<html lang="id">

<head>
    @@include('../partials/head.html', {
    "title": "Detail Produk - AMPEDIG",
    "description": "Detail spesifikasi lengkap produk CCTV terbaik dari AMPEDIG."
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

        /* Product image aspect (Square 1:1) */
        .img-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            /* 1:1 Aspect Ratio (Square) */
            overflow: hidden;
        }

        .img-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-700 min-h-screen flex flex-col">

    <!-- ===== STICKY NAVBAR ===== -->
    <header class="katalog-header sticky top-0 z-50 bg-white/90 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <!-- Logo -->
                <a href="katalog.html" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="../assets/images/logo.png" alt="AMPEDIG" class="h-8 w-auto rounded-lg">
                    <span class="font-semibold text-lg text-slate-800 hidden sm:block">AMPEDIG</span>
                </a>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="cart.html"
                        class="relative text-slate-600 hover:text-brand-600 transition-colors p-2.5 flex items-center">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span id="cartBadge"
                            class="absolute -top-0.5 -right-0.5 bg-rose-500 text-white text-[9px] w-4.5 h-4.5 rounded-full flex items-center justify-center font-semibold hidden">0</span>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="btn btn-primary btn-sm flex items-center gap-2 rounded-xl">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== BREADCRUMB ===== -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
        <ol class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <li><a href="katalog.html" class="hover:text-slate-600">Katalog</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px]"></i></li>
            <li id="breadcrumbCat" class="hover:text-slate-600 capitalize">Kategori</li>
            <li><i class="fa-solid fa-chevron-right text-[10px]"></i></li>
            <li id="breadcrumbName" class="text-slate-600 truncate max-w-[180px] sm:max-w-xs">Nama Produk</li>
        </ol>
    </nav>

    <!-- ===== PRODUCT DETAILS ===== -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 w-full">
        <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 bg-white rounded-3xl border border-slate-200 overflow-hidden p-6 md:p-10">

            <!-- Left Column: Product Image -->
            <div class="lg:col-span-6 flex flex-col gap-4">
                <div class="img-container rounded-2xl border border-slate-100 overflow-hidden">
                    <img id="productImg" src="" alt="Gambar Produk" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="lg:col-span-6 flex flex-col justify-between">
                <div>


                    <!-- Title -->
                    <h1 id="productName"
                        class="text-xl sm:text-2xl lg:text-3xl font-semibold text-slate-800 leading-snug mb-4"></h1>

                    <!-- Price -->
                    <div class="bg-brand-50/40 border border-brand-100/50 rounded-2xl px-5 py-4 mb-6">
                        <p class="text-xs text-slate-400 font-semibold mb-1">Harga Retail / Unit</p>
                        <p id="productPrice" class="text-2xl font-semibold text-slate-900"></p>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h2 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi Produk</h2>
                        <p id="productDesc" class="text-sm text-slate-500 leading-relaxed"></p>
                    </div>

                    <!-- Dynamic Specs Table -->
                    <div class="border-t border-slate-100 pt-6 mb-8">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Spesifikasi Lengkap</h3>
                        <div id="specList" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1">
                            <!-- JS populated specs -->
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="border-t border-slate-100 pt-6 flex flex-col sm:flex-row gap-4">
                    <button onclick="addToCart()"
                        class="flex-1 py-4 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus text-sm"></i>
                        <span>Tambah ke Keranjang</span>
                    </button>
                    <a id="waOrderBtn" href="#" target="_blank"
                        class="flex-1 py-4 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Beli Langsung (WA)</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-800 text-slate-400 py-8 px-4 text-sm border-t border-slate-700 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="../assets/images/logo.png" alt="AMPEDIG" class="h-7 w-auto rounded-lg">
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

        // Retrieve and parse item from localStorage
        const rawProduct = localStorage.getItem('selectedProduct');
        if (!rawProduct) {
            window.location.href = 'katalog.html';
        }
        const product = JSON.parse(rawProduct);

        // Bind HTML elements
        document.getElementById('productImg').src = product.img;
        document.getElementById('productImg').alt = product.name;

        let catLabel = product.cat;
        if (product.cat === 'kamera') catLabel = 'Kamera CCTV';
        else if (product.cat === 'dvr') catLabel = 'DVR / NVR';
        else if (product.cat === 'hdd') catLabel = 'Hardisk CCTV';
        else if (product.cat === 'aksesori') catLabel = 'Aksesori';
        else if (product.cat === 'kabel') catLabel = 'Kabel';
        else if (product.cat === 'jasa') catLabel = 'Jasa Pasang';
        else if (product.cat === 'paket') catLabel = 'Paket Bundling';
        document.getElementById('breadcrumbCat').innerText = catLabel;
        document.getElementById('breadcrumbCat').setAttribute('href',
        'katalog.html'); // Clicking category returns to catalog
        document.getElementById('productName').innerText = product.name;
        document.getElementById('breadcrumbName').innerText = product.name;

        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(product.price);
        const unit = product.unit || 'pcs';

        document.getElementById('productPrice').innerText = `${formatted} / ${unit}`;
        document.getElementById('productDesc').innerText = product.desc ||
            'Produk berkualitas dari AMPEDIG. Dijamin orisinil dan bergaransi.';

        // Build specifications list based on Product ERD fields
        const specList = document.getElementById('specList');
        const specs = [{
                name: 'Kategori',
                value: catLabel
            },
            {
                name: 'Merk / Brand',
                value: product.brand
            },
            {
                name: 'Satuan (Unit)',
                value: unit
            }
        ];

        specList.innerHTML = specs.map(s => `
            <div class="flex justify-between py-2.5 border-b border-slate-100 text-xs">
                <span class="text-slate-400 font-semibold">${s.name}</span>
                <span class="text-slate-700 font-semibold">${s.value}</span>
            </div>
        `).join('');

        // Pre-fill WA Message Link
        const msg =
            `Halo AMPEDIG 👋, saya tertarik dengan produk:\n\n*${product.name}*\nHarga: ${formatted}\n\nBisa dibantu info lebih lanjut mengenai spesifikasi & ketersediaannya?`;
        document.getElementById('waOrderBtn').href = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`;

        // Add Product to Cart
        function addToCart() {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existingIndex = cart.findIndex(item => item.name === product.name);
            if (existingIndex > -1) {
                cart[existingIndex].qty += 1;
            } else {
                cart.push({
                    name: product.name,
                    price: product.price,
                    brand: product.brand,
                    img: product.img,
                    cat: product.cat,
                    unit: unit,
                    qty: 1
                });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            window.location.href = 'cart.html';
        }

        // Update Cart Badge Count
        function updateCartBadge() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
            const badge = document.getElementById('cartBadge');
            if (badge) {
                badge.innerText = totalQty;
                badge.classList.toggle('hidden', totalQty === 0);
            }
        }
        window.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>

</body>

</html>
