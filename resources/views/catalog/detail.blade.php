<!DOCTYPE html>
<html lang="id">

<head>
    @section('title', $product->name . ' - CCTV Palembang City')
    @include('dashboard.partials.head')

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Beli {{ $product->name }} dengan harga terbaik di CCTV Palembang City. Merk: {{ $product->merk ?? '-' }}. {{ Str::limit(strip_tags($product->description), 130) }}">
    <meta name="keywords"
        content="{{ $product->name }}, cctv {{ $product->name }}, {{ $product->merk ?? '' }}, cctv palembang, cctv palembang city, pasang cctv palembang">
    <meta name="author" content="CCTV Palembang City">
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $product->name }} - CCTV Palembang City">
    <meta property="og:description"
        content="Beli {{ $product->name }} dengan harga terbaik di CCTV Palembang City. Merk: {{ $product->merk ?? '-' }}.">
    <meta property="og:image" content="{{ asset('storage/' . $product->image) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ $product->name }} - CCTV Palembang City">
    <meta property="twitter:description"
        content="Beli {{ $product->name }} dengan harga terbaik di CCTV Palembang City. Merk: {{ $product->merk ?? '-' }}.">
    <meta property="twitter:image" content="{{ asset('storage/' . $product->image) }}">
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

        .cart-badge {
            position: absolute !important;
            top: -2px !important;
            right: -2px !important;
            background-color: #f43f5e !important;
            color: #ffffff !important;
            font-size: 9px !important;
            font-weight: 700 !important;
            width: 16px !important;
            height: 16px !important;
            border-radius: 9999px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
        }

        /* Grid fallbacks for missing Tailwind classes */
        @media (min-width: 1024px) {
            .lg\:grid-cols-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }

            .lg\:col-span-6 {
                grid-column: span 6 / span 6 !important;
            }
        }

        /* Specs table grid columns & gap fallbacks */
        .gap-x-6 {
            column-gap: 1.5rem !important;
        }

        @media (min-width: 640px) {
            .sm\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        /* Product image aspect (Square 1:1) */
        .img-container {
            position: relative !important;
            width: 100% !important;
            padding-bottom: 100% !important;
            /* 1:1 Aspect Ratio (Square) */
            overflow: hidden !important;
        }

        .img-container img {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        /* Prose: render HTML dari rich text editor */
        .product-desc p {
            margin-bottom: 0.6rem;
            line-height: 1.65;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .product-desc ul,
        .product-desc ol {
            padding-left: 1.25rem;
            margin-bottom: 0.6rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .product-desc ul {
            list-style-type: disc;
        }

        .product-desc ol {
            list-style-type: decimal;
        }

        .product-desc li {
            margin-bottom: 0.2rem;
            line-height: 1.65;
        }

        .product-desc strong {
            font-weight: 600;
            color: #374151;
        }

        .product-desc h1,
        .product-desc h2,
        .product-desc h3 {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            margin-top: 0.75rem;
            font-size: 0.875rem;
        }

        .product-desc table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            margin-bottom: 0.6rem;
        }

        .product-desc th,
        .product-desc td {
            border: 1px solid #e2e8f0;
            padding: 0.35rem 0.6rem;
            text-align: left;
        }

        .product-desc th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-700 min-h-screen flex flex-col">

    <!-- ===== STICKY NAVBAR ===== -->
    <header class="katalog-header sticky top-0 z-50 bg-white/90 border-b border-slate-100">
        <div class="katalog-container">
            <div class="flex items-center justify-between h-16 gap-4">
                <!-- Logo -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="CCTV Palembang City"
                        class="katalog-logo rounded-lg">
                    <span class="font-semibold text-lg text-slate-800 hidden sm:block">CCTV Palembang City</span>
                </a>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('catalog.cart') }}"
                        class="relative text-slate-600 hover:text-brand-600 transition-colors p-2.5 flex items-center">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span id="cartBadge" class="cart-badge hidden">0</span>
                    </a>
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank"
                        class="btn btn-primary btn-sm flex items-center gap-2 rounded-xl">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== BREADCRUMB ===== -->
    <nav class="katalog-container py-5">
        <ol class="flex items-center gap-2 text-xs font-semibold text-slate-400">
            <li><a href="{{ route('catalog.index') }}" class="hover:text-slate-600">Katalog</a></li>
            <li><i class="fa-solid fa-chevron-right text-[10px]"></i></li>
            <li id="breadcrumbCat" class="hover:text-slate-600 capitalize">{{ $product->category->name ?? 'Kategori' }}
            </li>
            <li><i class="fa-solid fa-chevron-right text-[10px]"></i></li>
            <li id="breadcrumbName" class="text-slate-600 truncate max-w-[180px] sm:max-w-xs">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- ===== PRODUCT DETAILS ===== -->
    <main class="flex-grow katalog-container pb-20 w-full">
        <div
            class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 bg-white rounded-3xl border border-slate-200 overflow-hidden p-6 md:p-10">

            <!-- Left Column: Product Image -->
            <div class="lg:col-span-6 flex flex-col gap-4">
                <div class="img-container rounded-2xl border border-slate-100 overflow-hidden">
                    <img id="productImg"
                        src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x600/e0f2fe/0284c7?text=' . urlencode($product->name) }}"
                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Right Column: Product Info -->
            <div class="lg:col-span-6 flex flex-col justify-between">
                <div>

                    <!-- Title -->
                    <h1 id="productName"
                        class="text-xl sm:text-2xl lg:text-3xl font-semibold text-slate-800 leading-snug mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="bg-brand-50/40 border border-brand-100/50 rounded-2xl px-5 py-4 mb-6">
                        <p class="text-xs text-slate-400 font-semibold mb-1">Harga Retail / Unit</p>
                        <p id="productPrice" class="text-2xl font-semibold text-slate-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }} / {{ $product->unit ?? 'pcs' }}
                        </p>
                    </div>

                    <!-- Description: render HTML dari rich text editor -->
                    <div class="mb-6">
                        <h2 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi Produk</h2>
                        <div id="productDesc" class="product-desc">
                            {!! $product->description ??
                                '<p>Produk berkualitas dari CCTV Palembang City. Dijamin orisinil dan bergaransi.</p>' !!}
                        </div>
                    </div>

                    <!-- Dynamic Specs Table -->
                    <div class="border-t border-slate-100 pt-6 mb-8">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Spesifikasi Lengkap</h3>
                        <div id="specList" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1">
                            @php
                                $specs = [
                                    ['name' => 'Kategori', 'value' => $product->category->name ?? '-'],
                                    ['name' => 'Merk / Brand', 'value' => $product->merk ?? 'Generic'],
                                    ['name' => 'Satuan (Unit)', 'value' => $product->unit ?? 'pcs'],
                                ];
                            @endphp
                            @foreach ($specs as $spec)
                                <div class="flex justify-between py-2.5 border-b border-slate-100 text-xs">
                                    <span class="text-slate-400 font-semibold">{{ $spec['name'] }}</span>
                                    <span class="text-slate-700 font-semibold">{{ $spec['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="border-t border-slate-100 pt-6 flex flex-col sm:flex-row gap-4">
                    <button onclick="addToCart()"
                        class="btn btn-primary flex-1 rounded-xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus text-sm"></i>
                        <span>Tambah ke Keranjang</span>
                    </button>
                    <a id="waOrderBtn" href="#" target="_blank"
                        class="btn btn-white flex-1 rounded-xl flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Beli Langsung (WA)</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-800 text-slate-400 py-8 px-4 text-sm border-t border-slate-700 mt-auto">
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
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        const WHATSAPP_NUMBER = '{{ config('services.whatsapp.number') }}';

        // Data produk dari server untuk dipakai fungsi cart & WA
        const product = {
            id: {{ $product->id }},
            name: @json($product->name),
            price: {{ (float) $product->price }},
            brand: @json($product->merk ?? 'Generic'),
            img: @json(
                $product->image
                    ? asset('storage/' . $product->image)
                    : 'https://placehold.co/600x600/e0f2fe/0284c7?text=' . urlencode($product->name)),
            cat: @json($product->category->slug ?? ''),
            category_name: @json($product->category->name ?? 'Uncategorized'),
            unit: @json($product->unit ?? 'pcs')
        };

        const unit = product.unit;

        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(product.price);

        // Pre-fill WA Message Link
        const msg =
            `Halo CCTV Palembang City 👋, saya tertarik dengan produk:\n\n*${product.name}*\nHarga: ${formatted} / ${unit}\n\nBisa dibantu info lebih lanjut mengenai spesifikasi & ketersediaannya?`;
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

            // Record interest category via tracker
            if (typeof trackProductInterest === 'function') {
                trackProductInterest(product.category_name);
            }

            // Show Success Notification with SweetAlert Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Berhasil...!',
                text: 'Produk ditambahkan ke keranjang.'
            });
            updateCartBadge();
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

    @include('catalog.partials.user-tracker')
</body>

</html>
