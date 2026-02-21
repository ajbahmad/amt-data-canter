@props([
    'paginator',
    'showPageInfo' => true,
    'pageInfoText' => null,
    'previousText' => 'Sebelumnya',
    'nextText' => 'Berikutnya',
    'maxVisiblePages' => 5
])

@php
    $start = max(1, $paginator->currentPage() - floor($maxVisiblePages / 2));
    $end = min($paginator->lastPage(), $start + $maxVisiblePages - 1);

    // Adjust start if we're near the end
    if ($end - $start + 1 < $maxVisiblePages) {
        $start = max(1, $end - $maxVisiblePages + 1);
    }
@endphp

@if($paginator->hasPages())
<div class="md:flex text-center pt-3 justify-between items-center border-t border-border dark:border-darkborder">
    @if($showPageInfo)
    <div>
        <p class="font-medium text-dark dark:text-white">
            @if($pageInfoText)
                {{ $pageInfoText }}
            @else
                Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }}
                dari {{ $paginator->total() }} data
            @endif
        </p>
    </div>
    @endif

    <div class="mt-2 md:mt-0">
        <nav class="flex items-center gap-x-1" role="navigation" aria-label="Pagination Navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-400 bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:bg-gray-700" aria-disabled="true">
                    <i class="ti ti-chevron-left text-sm"></i>
                    <span class="hidden sm:inline">{{ $previousText }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
                   rel="prev"
                   aria-label="Previous page">
                    <i class="ti ti-chevron-left text-sm"></i>
                    <span class="hidden sm:inline">{{ $previousText }}</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-x-1">
                {{-- First Page --}}
                @if($start > 1)
                    <a href="{{ $paginator->url(1) }}"
                       class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
                       aria-label="Go to page 1">
                        1
                    </a>
                    @if($start > 2)
                        <span class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-500 py-2 px-3 text-sm">...</span>
                    @endif
                @endif

                {{-- Page Numbers --}}
                @for($page = $start; $page <= $end; $page++)
                    @if ($page == $paginator->currentPage())
                        <span class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-blue-600 text-white py-2 px-3 text-sm rounded-lg focus:outline-none font-medium"
                              aria-current="page"
                              aria-label="Current page {{ $page }}">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}"
                           class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
                           aria-label="Go to page {{ $page }}">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Last Page --}}
                @if($end < $paginator->lastPage())
                    @if($end < $paginator->lastPage() - 1)
                        <span class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-500 py-2 px-3 text-sm">...</span>
                    @endif
                    <a href="{{ $paginator->url($paginator->lastPage()) }}"
                       class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
                       aria-label="Go to page {{ $paginator->lastPage() }}">
                        {{ $paginator->lastPage() }}
                    </a>
                @endif
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
                   rel="next"
                   aria-label="Next page">
                    <span class="hidden sm:inline">{{ $nextText }}</span>
                    <i class="ti ti-chevron-right text-sm"></i>
                </a>
            @else
                <span class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-400 bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:bg-gray-700" aria-disabled="true">
                    <span class="hidden sm:inline">{{ $nextText }}</span>
                    <i class="ti ti-chevron-right text-sm"></i>
                </span>
            @endif
        </nav>
    </div>
</div>
@endif
