@extends('dashboard.layouts.app')

@section('title', 'Tambah Transaksi')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection

@section('content')
    <div class="flex-1 p-4 md:p-8">
        <div class="w-full">
            <!-- 1 Panel Form -->
            <form action="{{ route('transactions.store') }}" method="POST" id="form-transaksi">
                @csrf
                <div class="bg-white border border-slate-200 rounded-2xl p-6 lg:p-8 space-y-8">

                    <!-- Informasi Umum -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-3 border-b border-slate-100">
                            Buat Transaksi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi
                                    <span class="text-rose-500">*</span></label>
                                <input type="date" name="transaction_date" class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-brand-500 transition-colors" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                                @error('transaction_date')
                                    <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pelanggan
                                    <span class="text-rose-500">*</span></label>
                                <select class="select2-customer w-full" name="customer_id" required>
                                    <option></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->full_name }} ({{ $customer->whatsapp_number ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-slate-400 mt-2">Belum ada pelanggan? <a
                                        href="{{ route('customers.create') }}"
                                        class="text-brand-600 font-semibold hover:text-brand-700 transition">Tambah
                                        Baru</a></p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status
                                    Pembayaran <span class="text-rose-500">*</span></label>
                                <select class="select2-status w-full" name="payment_status" required>
                                    <option value="pending" {{ old('payment_status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ old('payment_status') === 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                                    <option value="canceled" {{ old('payment_status') === 'canceled' ? 'selected' : '' }}>Canceled (Gagal)</option>
                                </select>
                                @error('payment_status')
                                    <p class="text-sm text-rose-500 font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detail Produk -->
                    <div>
                        <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100">
                            <h3 class="text-lg font-semibold text-slate-800">
                                Daftar Barang Yang Dibeli
                            </h3>
                            <button type="button" onclick="openProductModal()"
                                class="btn btn-primary btn-sm flex items-center gap-2">
                                <i class="fa-solid fa-cart-plus"></i> Pilih Produk
                            </button>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                            <!-- Table for selected products (Scrollable on mobile) -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left min-w-[600px]">
                                    <thead class="bg-slate-100/50 text-slate-500 text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="p-4 font-semibold">Produk</th>
                                            <th class="p-4 font-semibold w-40 text-right">Harga</th>
                                            <th class="p-4 font-semibold w-32 text-center">Qty</th>
                                            <th class="p-4 font-semibold w-40 text-right">Subtotal</th>
                                            <th class="p-4 font-semibold w-16 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 bg-white" id="product-list-body">
                                        <!-- Empty state -->
                                        <tr id="empty-state">
                                            <td colspan="5" class="p-8 text-center text-slate-400">
                                                <i class="fa-solid fa-box-open text-3xl mb-3 text-slate-300"></i>
                                                <p>Belum ada produk yang dipilih.</p>
                                            </td>
                                        </tr>
                                        <!-- Selected products will be injected here -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Footer for Totals -->
                            <div class="bg-slate-50/50 border-t border-slate-200 p-4 sm:p-6">
                                <div class="flex flex-col sm:flex-row justify-end items-end sm:items-center gap-4 sm:gap-8">
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-slate-500 block mb-1">Total Item Qty</span>
                                        <span id="summary-total-item" class="text-lg font-semibold text-slate-800">0</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-slate-500 block mb-1">Grand Total</span>
                                        <span id="summary-grand-total" class="text-2xl font-semibold text-brand-600">Rp 0</span>
                                        <input type="hidden" name="grand_total" id="input-grand-total" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex gap-3 justify-end">
                        <a href="{{ route('transactions.index') }}" class="btn btn-white px-6">Batal</a>
                        <button type="button" onclick="submitForm()" class="btn btn-primary px-6 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Modal Pilih Produk -->
    <div id="productModal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeProductModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col relative z-10 transform scale-95 transition-transform duration-300"
                id="productModalContent">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-semibold text-slate-800">Pilih Produk CCTV</h3>
                    <button type="button" onclick="closeProductModal()"
                        class="text-slate-400 hover:text-slate-500 hover:bg-slate-100 w-8 h-8 flex justify-center items-center rounded-xl transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Modal Search -->
                <div class="p-6 border-b border-slate-100">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-slate-400"></i>
                        </div>
                        <input type="text" id="searchProduct"
                            class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-brand-500 transition-colors"
                            placeholder="Cari nama produk atau merk...">
                    </div>
                </div>

                <!-- Modal Body (Grid Produk) -->
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar bg-slate-50/30">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="modal-product-grid">

                        @foreach ($products as $product)
                            @php
                                $productImage = $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x100/e2e8f0/64748b?text=' . urlencode(substr($product->name, 0, 3));
                            @endphp
                            <div class="bg-white border border-slate-200 rounded-xl p-3 hover:border-brand-300 hover:shadow-md transition-all flex gap-3 items-center group cursor-pointer"
                                onclick="selectProduct({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->merk ?? '-') }}', {{ $product->price }}, '{{ $productImage }}')">
                                <div class="w-16 h-16 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-100">
                                    <img src="{{ $productImage }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-slate-800 group-hover:text-brand-600 transition-colors">
                                        {{ $product->name }}</h4>
                                    <p class="text-[11px] font-medium text-slate-500 mb-1 inline-block bg-slate-100 px-1.5 py-0.5 rounded">
                                        {{ $product->merk ?? '-' }}</p>
                                    <p class="text-sm font-semibold text-slate-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- Page Specific Script -->
    <script>
        // Array to store selected products
        let selectedProducts = [];

        // Format Mata Uang Rupiah (IDR)
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi Select2
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-customer').select2({
                    placeholder: 'Pilih pelanggan...',
                    width: '100%'
                });

                $('.select2-status').select2({
                    minimumResultsForSearch: Infinity,
                    width: '100%'
                });
            }

            // Real-time Search di Modal
            const searchInput = document.getElementById('searchProduct');
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                const items = document.querySelectorAll('#modal-product-grid > div');
                items.forEach(item => {
                    const title = item.querySelector('h4').textContent.toLowerCase();
                    const brand = item.querySelector('p').textContent.toLowerCase();
                    if (title.includes(term) || brand.includes(term)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Modal Functions
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('productModalContent');

        function openProductModal() {
            modal.classList.remove('hidden');
            // Sedikit delay untuk trigger animasi
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);

            // Reset pencarian
            document.getElementById('searchProduct').value = '';
            document.querySelectorAll('#modal-product-grid > div').forEach(item => {
                item.style.display = 'flex';
            });
        }

        function closeProductModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Logic Memilih Produk
        function selectProduct(id, name, brand, price, image) {
            // Cek apakah produk sudah ada
            const existingProduct = selectedProducts.find(p => p.id === id);

            if (existingProduct) {
                // Jika sudah ada, tambah quantity-nya
                existingProduct.qty += 1;
            } else {
                // Jika belum ada, tambahkan ke array
                selectedProducts.push({
                    id: id,
                    name: name,
                    brand: brand,
                    price: price,
                    image: image,
                    qty: 1
                });
            }

            renderProductTable();
            closeProductModal();
        }

        // Fungsi Render Ulang Tabel Produk
        function renderProductTable() {
            const tbody = document.getElementById('product-list-body');
            const emptyState = document.getElementById('empty-state');

            // Clear existing rows (except empty state)
            const rows = tbody.querySelectorAll('.product-item-row');
            rows.forEach(row => row.remove());

            if (selectedProducts.length === 0) {
                emptyState.style.display = 'table-row';
            } else {
                emptyState.style.display = 'none';

                selectedProducts.forEach((product, index) => {
                    const tr = document.createElement('tr');
                    tr.className = 'product-item-row hover:bg-slate-50/50 transition-colors';
                    tr.innerHTML = `
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                    <img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-800">${product.name}</h4>
                                    <p class="text-xs text-slate-500">${product.brand}</p>
                                    <!-- Hidden inputs for form submission -->
                                    <input type="hidden" name="product_id[]" value="${product.id}">
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-right">
                            <span class="text-sm text-slate-600">${formatRupiah(product.price)}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center">
                                <input type="number" name="quantity[]" min="1" value="${product.qty}" 
                                    class="w-16 px-2 py-1.5 text-center border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-brand-500"
                                    onchange="updateQuantity(${index}, this.value)">
                            </div>
                        </td>
                        <td class="p-4 text-right">
                            <span class="text-sm font-semibold text-slate-800">${formatRupiah(product.price * product.qty)}</span>
                        </td>
                        <td class="p-4 text-center">
                            <button type="button" onclick="removeProduct(${index})" class="text-red-400 hover:text-red-600 hover:bg-red-50 w-8 h-8 rounded-lg transition-colors inline-flex items-center justify-center">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            calculateTotals();
        }

        // Update Quantity via input
        function updateQuantity(index, newQty) {
            const qty = parseInt(newQty);
            if (qty > 0) {
                selectedProducts[index].qty = qty;
                renderProductTable();
            } else {
                // Jangan perbolehkan kurang dari 1
                renderProductTable(); // render ulang agar input kembali ke nilai asal
            }
        }

        // Hapus produk
        function removeProduct(index) {
            selectedProducts.splice(index, 1);
            renderProductTable();
        }

        // Kalkulasi Total
        function calculateTotals() {
            let totalQty = 0;
            let grandTotal = 0;

            selectedProducts.forEach(p => {
                totalQty += p.qty;
                grandTotal += (p.price * p.qty);
            });

            document.getElementById('summary-total-item').textContent = totalQty;
            document.getElementById('summary-grand-total').textContent = formatRupiah(grandTotal);
            document.getElementById('input-grand-total').value = grandTotal;
        }

        // Submit Form
        function submitForm() {
            if (selectedProducts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Produk',
                    text: 'Silakan pilih minimal 1 produk terlebih dahulu!',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            const form = document.getElementById('form-transaksi');
            if (form.reportValidity()) {
                form.submit();
            }
        }
    </script>
@endsection
