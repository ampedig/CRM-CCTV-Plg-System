{{-- Pagination Component for New Theme --}}
{{-- Usage: @include('new.components.pagination', ['paginator' => $data]) --}}

@if ($paginator->total() > 0)
    <div class="p-5 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
        {{-- Info text --}}
        <span class="text-sm text-slate-500 font-medium">
            Menampilkan
            <span
                class="font-semibold text-slate-700">{{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span>
            data
        </span>

        {{-- Pagination buttons (only show if more than 1 page) --}}
        @if ($paginator->hasPages())
            <nav aria-label="Page navigation">
                <ul class="inline-flex items-center -space-x-px">
                    {{-- Previous Page Link --}}
                    <li>
                        @if ($paginator->onFirstPage())
                            <span
                                class="flex items-center justify-center w-9 h-9 ml-0 leading-tight text-slate-400 bg-slate-50 border border-slate-200 rounded-l-lg cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </span>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}"
                                class="flex items-center justify-center w-9 h-9 ml-0 leading-tight text-slate-500 bg-white border border-slate-200 rounded-l-lg hover:bg-slate-50 hover:text-slate-700 transition">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </a>
                        @endif
                    </li>

                    {{-- Pagination Elements --}}
                    @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span
                                    class="flex items-center justify-center w-9 h-9 leading-tight text-brand-600 bg-brand-50 border border-brand-200 font-semibold z-10 transition">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="flex items-center justify-center w-9 h-9 leading-tight text-slate-500 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-700 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        </li>
                    @endforeach

                    {{-- Next Page Link --}}
                    <li>
                        @if ($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}"
                                class="flex items-center justify-center w-9 h-9 leading-tight text-slate-500 bg-white border border-slate-200 rounded-r-lg hover:bg-slate-50 hover:text-slate-700 transition">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        @else
                            <span
                                class="flex items-center justify-center w-9 h-9 leading-tight text-slate-400 bg-slate-50 border border-slate-200 rounded-r-lg cursor-not-allowed">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        @endif
                    </li>
                </ul>
            </nav>
        @endif
    </div>
@endif
