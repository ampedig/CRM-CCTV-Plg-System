<!DOCTYPE html>
<html lang="id">

<head>
    @section('title', 'Katalog Produk')
    @include('dashboard.partials.head')

    <style>
        html,
        body.katalog-page {
            height: auto !important;
            min-height: 100% !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            overscroll-behavior: auto !important;
        }

        body.katalog-page.modal-open {
            overflow: hidden !important;
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

        /* Category pill active */
        .cat-pill.active {
            background-color: var(--brand-600, #0284c7);
            color: white;
            border-color: var(--brand-600, #0284c7);
        }

        .cat-pill {
            flex-shrink: 0;
        }

        /* Scrollable category list */
        .category-scroll-container {
            display: flex;
            overflow-x: auto;
            gap: 0.5rem;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
            padding-bottom: 6px;
            margin-bottom: -6px; /* Offset the padding bottom */
        }

        .category-scroll-container::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }

        /* Product card hover lift */
        .product-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
        }

        /* Sticky header blur */
        .katalog-header {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Hero gradient */
        .hero-gradient {
            background: linear-gradient(135deg, #0369a1 0%, #0284c7 50%, #0ea5e9 100%);
        }

        /* Search focus glow */
        #searchInput:focus {
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
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

        /* Responsive Product Grid fallback */
        #productGrid {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 1rem !important;
        }

        @media (min-width: 640px) {
            #productGrid {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
        }

        @media (min-width: 1024px) {
            #productGrid {
                grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
            }
        }

        /* Fixed height/aspect ratio for product images to be square on all screens */
        .product-card img {
            width: 100% !important;
            height: auto !important;
            aspect-ratio: 1 / 1 !important;
            object-fit: cover !important;
        }

        /* Fallback for search button border radius */
        .rounded-r-2xl {
            border-top-right-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
        }
    </style>
</head>

<body class="katalog-page bg-slate-50 font-sans antialiased text-slate-700">

    <!-- ===== STICKY NAVBAR ===== -->
    <header class="katalog-header sticky top-0 z-50 bg-white/90 border-b border-slate-100">
        <div class="katalog-container">
            <div class="flex items-center justify-between h-16 gap-4">

                <!-- Logo -->
                <a href="#" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="AMPEDIG" class="katalog-logo rounded-lg">
                    <span class="font-semibold text-lg text-slate-800 hidden sm:block">AMPEDIG</span>
                </a>

                <!-- Search Bar (Desktop) -->
                <div class="flex-1 max-w-xl hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" id="searchInputNav" placeholder="Cari produk, merk, kategori..."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 focus:bg-white transition-all"
                            oninput="syncSearch(this.value)">
                    </div>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="cart.html"
                        class="relative text-slate-600 hover:text-brand-600 transition-colors p-2.5 flex items-center">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span id="cartBadge"
                            class="absolute -top-0.5 -right-0.5 bg-rose-500 text-white text-[9px] w-4.5 h-4.5 rounded-full flex items-center justify-center font-semibold hidden">0</span>
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

    <!-- ===== HERO SECTION ===== -->
    <section class="hero-gradient text-white py-10 md:py-16 px-4">
        <div class="katalog-container text-center">
            <span
                class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-semibold tracking-wider uppercase mb-4">
                🔒 Keamanan Rumah & Bisnis Anda
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold leading-tight mb-4">
                Solusi CCTV Terbaik<br class="hidden sm:block"> untuk Anda
            </h1>
            <p class="text-blue-100 text-base sm:text-lg max-w-2xl mx-auto mb-8">
                Kamera keamanan, DVR, aksesori, dan jasa instalasi profesional. Semua tersedia dengan harga kompetitif.
            </p>

            <!-- Search Bar -->
            <div class="max-w-lg mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari produk, merk..."
                        class="w-full pl-12 pr-4 py-4 bg-white border border-slate-100 rounded-2xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all"
                        oninput="syncSearch(this.value)">
                    <button
                        class="absolute inset-y-0 right-0 px-5 text-white bg-brand-600 hover:bg-brand-700 rounded-r-2xl font-semibold text-sm transition-colors">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="katalog-container py-10">

        <!-- Category Pills -->
        <div class="mb-8">
            <h2 class="text-base font-semibold text-slate-700 mb-4">Kategori Produk</h2>
            <div class="category-scroll-container" id="categoryList">
                <button
                    class="cat-pill active px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:border-brand-400 transition-all"
                    data-cat="all">
                    Semua
                </button>
                @foreach ($categories as $category)
                <button
                    class="cat-pill px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:border-brand-400 transition-all"
                    data-cat="{{ $category->slug }}">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Toolbar: Result count + Sort -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <p id="resultCount" class="text-sm text-slate-500">Menampilkan <span
                    class="font-semibold text-slate-700">{{ $products->count() }}</span> produk</p>
            <select id="sortSelect" onchange="sortProducts(this.value)"
                class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors text-slate-600">
                <option value="default">Urutkan: Default</option>
                <option value="price-asc">Harga: Terendah</option>
                <option value="price-desc">Harga: Tertinggi</option>
                <option value="name-asc">Nama: A–Z</option>
            </select>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4" id="productGrid">
            @forelse($products as $product)
            <a href="{{ route('catalog.detail', $product->slug) }}"
                class="product-card cursor-pointer bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col hover:border-brand-400 transition-all"
                data-cat="{{ $product->category->slug ?? '' }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                data-brand="{{ $product->merk ?? 'Generic' }}"
                data-desc="{{ $product->description ?? '' }}"
                data-unit="{{ $product->unit ?? 'pcs' }}" data-is-active="{{ $product->is_active ? 'true' : 'false' }}">
                <div class="relative">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/e0f2fe/0284c7?text=' . urlencode($product->name) }}"
                        alt="{{ $product->name }}" class="w-full h-40 object-cover"
                        onerror="this.src='https://placehold.co/400x300/e0f2fe/0284c7?text={{ urlencode($product->name) }}'">
                </div>
                <div class="p-3 flex flex-col flex-1">
                    <span
                        class="text-[10px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md w-fit mb-1.5">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    <h3 class="text-sm font-semibold text-slate-800 leading-snug mb-2 flex-1">{{ $product->name }}</h3>
                    <p class="text-base font-semibold text-slate-900 mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div
                        class="w-full py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 mt-auto">
                        Lihat Detail
                    </div>
                </div>
            </a>
            @empty
                <!-- No Products -> Let JS handle or handled below -->
            @endforelse
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-20">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">Produk Tidak Ditemukan</h3>
            <p class="text-sm text-slate-400">Coba kata kunci atau kategori yang berbeda.</p>
            <button onclick="resetFilter()" class="mt-5 btn btn-primary btn-sm rounded-xl">Reset Filter</button>
        </div>

    </main>

    <!-- ===== CTA SECTION ===== -->
    <section class="bg-brand-600 text-white py-12 px-4 mt-10">
        <div class="katalog-container text-center">
            <h2 class="text-2xl font-semibold mb-3">Butuh Konsultasi Gratis?</h2>
            <p class="text-blue-100 mb-6 text-sm">Tim kami siap membantu Anda memilih produk yang sesuai kebutuhan dan anggaran.</p>
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank"
                class="inline-flex items-center gap-2 bg-white text-brand-700 px-6 py-3 rounded-xl font-semibold hover:bg-slate-50 transition-colors">
                <i class="fa-brands fa-whatsapp text-green-600 text-lg"></i>
                Chat WhatsApp Sekarang
            </a>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-slate-800 text-slate-400 py-8 px-4 text-sm pb-20 sm:pb-8">
        <div class="katalog-container flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="AMPEDIG" class="katalog-logo-footer rounded-lg">
                <span class="font-semibold text-white">AMPEDIG</span>
            </div>
            <p>©
                <script>
                    document.write(new Date().getFullYear())
                </script> AMPEDIG. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        const WHATSAPP_NUMBER = '{{ config('services.whatsapp.number') }}';

        let activeCategory = 'all';
        let searchTerm = '';
        let sortMode = 'default';

        // Sync dua search input (hero & navbar)
        function syncSearch(val) {
            searchTerm = val.toLowerCase();
            const heroInput = document.getElementById('searchInput');
            const navInput = document.getElementById('searchInputNav');
            if (heroInput) heroInput.value = val;
            if (navInput) navInput.value = val;
            applyFilter();
        }

        // Category filter
        document.getElementById('categoryList').addEventListener('click', (e) => {
            const btn = e.target.closest('.cat-pill');
            if (!btn) return;

            document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeCategory = btn.dataset.cat;
            applyFilter();
        });

        function sortProducts(mode) {
            sortMode = mode;
            applyFilter();
        }

        function applyFilter() {
            const grid = document.getElementById('productGrid');
            const cards = Array.from(grid.querySelectorAll('.product-card'));
            let visible = 0;

            // Filter
            cards.forEach(card => {
                const cat = card.dataset.cat;
                const name = card.dataset.name.toLowerCase();
                const brand = card.dataset.brand.toLowerCase();

                const matchCat = activeCategory === 'all' || cat === activeCategory;
                const matchSearch = name.includes(searchTerm) || brand.includes(searchTerm);

                if (matchCat && matchSearch) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Sort visible cards
            const visibleCards = cards.filter(c => c.style.display !== 'none');
            visibleCards.sort((a, b) => {
                if (sortMode === 'price-asc') return +a.dataset.price - +b.dataset.price;
                if (sortMode === 'price-desc') return +b.dataset.price - +a.dataset.price;
                if (sortMode === 'name-asc') return a.dataset.name.localeCompare(b.dataset.name);
                return 0;
            });
            visibleCards.forEach(c => grid.appendChild(c));

            // Update count
            document.getElementById('resultCount').innerHTML =
                `Menampilkan <span class="font-semibold text-slate-700">${visible}</span> produk`;

            // Empty state
            document.getElementById('emptyState').classList.toggle('hidden', visible > 0);
        }

        function resetFilter() {
            activeCategory = 'all';
            searchTerm = '';
            sortMode = 'default';
            document.getElementById('searchInput').value = '';
            document.getElementById('searchInputNav').value = '';
            document.getElementById('sortSelect').value = 'default';
            document.querySelectorAll('.cat-pill').forEach(b => b.classList.remove('active'));
            document.querySelector('.cat-pill[data-cat="all"]').classList.add('active');
            applyFilter();
        }

        // Order via WhatsApp
        function orderProduct(name, price) {
            const formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(price);
            const msg =
                `Halo AMPEDIG 👋, saya tertarik dengan produk:\n\n*${name}*\nHarga: ${formatted}\n\nBisa dibantu info lebih lanjut?`;
            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`, '_blank');
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
