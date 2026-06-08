@extends('dashboard.layouts.app')

@section('title', 'Chat History')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/css/select2.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="flex-1 p-8">
        <div class="max-w-screen-2xl mx-auto">
            <!-- Table Container -->
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <!-- Header Table -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <!-- Show Entries -->
                    <div class="flex items-center gap-2">
                        <form action="{{ route('chat-histories.index') }}" method="GET" class="flex items-center gap-2">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <span class="text-sm text-slate-500 font-medium">Show</span>
                            <select name="per_page" class="select2-show-entries w-24" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Main Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    #
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Nama Pelanggan
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Whatsapp
                                </th>
                                <th
                                    class="px-6 py-4 border-b border-slate-100 text-center t-title-data font-semibold text-slate-800 uppercase tracking-wider td-nowrap">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse ($chatHistories as $index => $chat)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $chatHistories->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-700 td-nowrap">
                                        {{ $chat->customer?->full_name ?? 'Bukan Pelanggan / Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 td-nowrap">
                                        {{ $chat->whatsapp_number }}
                                    </td>
                                    <td class="px-6 py-4 text-center td-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                onclick="showChat('{{ addslashes($chat->customer?->full_name ?? '-') }}', '{{ $chat->whatsapp_number }}', '{{ addslashes($chat->message) }}')"
                                                class="btn btn-primary btn-sm flex items-center gap-2">
                                                <i class="fa-solid fa-eye"></i> Show
                                            </button>
                                            <button class="btn btn-danger btn-icon btn-sm" title="Hapus"
                                                onclick="confirmDelete('{{ $chat->id }}')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <form id="delete-form-{{ $chat->id }}"
                                                action="{{ route('chat-histories.destroy', $chat->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data chat history ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @include('dashboard.components.pagination', ['paginator' => $chatHistories])
            </div>
        </div>
    </div>

    <!-- Modal Show Chat -->
    <div id="showChatModal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="hideModal('showChatModal')"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full scale-95 opacity-0 duration-300"
                id="showChatModalContent">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-semibold text-slate-800">Detail Pesan Masuk</h3>
                    <button type="button" onclick="hideModal('showChatModal')"
                        class="text-slate-400 hover:text-slate-500 hover:bg-slate-100 p-2 rounded-xl transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pelanggan</label>
                            <input type="text" id="modalCustomerName" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Whatsapp</label>
                            <input type="text" id="modalWhatsapp" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan</label>
                            <textarea id="modalMessage" rows="6" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 cursor-not-allowed resize-none leading-relaxed"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50">
                    <button type="button" onclick="hideModal('showChatModal')" class="btn btn-white">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.select2-show-entries').select2({
                    minimumResultsForSearch: Infinity
                });
            }

            // SweetAlert Toast Notifications
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Berhasil...!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });

        function showChat(customerName, whatsapp, message) {
            document.getElementById('modalCustomerName').value = customerName;
            document.getElementById('modalWhatsapp').value = whatsapp;
            document.getElementById('modalMessage').value = message;
            showModal('showChatModal');
        }

        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            if (modal && content) {
                modal.classList.remove('hidden');
                // Trigger reflow
                void modal.offsetWidth;
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            if (modal && content) {
                modal.classList.add('opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data riwayat chat ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                customClass: {
                    confirmButton: 'rounded-xl font-semibold px-6',
                    cancelButton: 'rounded-xl font-semibold text-slate-700 px-6'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
