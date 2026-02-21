@props([
    'paginator',
    'previousText' => 'Sebelumnya',
    'nextText' => 'Berikutnya',
    'maxVisiblePages' => 5,
    'size' => 'default' // 'small', 'default', 'large'
])

@php
    $start = max(1, $paginator->currentPage() - floor($maxVisiblePages / 2));
    $end = min($paginator->lastPage(), $start + $maxVisiblePages - 1);

    // Adjust start if we're near the end
    if ($end - $start + 1 < $maxVisiblePages) {
        $start = max(1, $end - $maxVisiblePages + 1);
    }

    // Size classes
    $sizeClasses = [
        'small' => 'min-h-[32px] min-w-[32px] py-1 px-2 text-xs',
        'default' => 'min-h-[38px] min-w-[38px] py-2 px-3 text-sm',
        'large' => 'min-h-[44px] min-w-[44px] py-3 px-4 text-base'
    ][$size] ?? $sizeClasses['default'];
@endphp

@if($paginator->hasPages())
<nav class="flex items-center justify-center gap-x-1" role="navigation" aria-label="Pagination Navigation">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="{{ $sizeClasses }} inline-flex justify-center items-center gap-x-1.5 rounded-lg text-gray-400 bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:bg-gray-700" aria-disabled="true">
            <i class="ti ti-chevron-left text-sm"></i>
            @if($size !== 'small')<span class="hidden sm:inline">{{ $previousText }}</span>@endif
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="{{ $sizeClasses }} inline-flex justify-center items-center gap-x-1.5 rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
           rel="prev"
           aria-label="Previous page">
            <i class="ti ti-chevron-left text-sm"></i>
            @if($size !== 'small')<span class="hidden sm:inline">{{ $previousText }}</span>@endif
        </a>
    @endif

    {{-- First Page --}}
    @if($start > 1)
        <a href="{{ $paginator->url(1) }}"
           class="{{ $sizeClasses }} flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
           aria-label="Go to page 1">
            1
        </a>
        @if($start > 2)
            <span class="{{ $sizeClasses }} flex justify-center items-center text-gray-500">...</span>
        @endif
    @endif

    {{-- Page Numbers --}}
    @for($page = $start; $page <= $end; $page++)
        @if ($page == $paginator->currentPage())
            <span class="{{ $sizeClasses }} flex justify-center items-center bg-blue-600 text-white rounded-lg focus:outline-none font-medium"
                  aria-current="page"
                  aria-label="Current page {{ $page }}">
                {{ $page }}
            </span>
        @else
            <a href="{{ $paginator->url($page) }}"
               class="{{ $sizeClasses }} flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
               aria-label="Go to page {{ $page }}">
                {{ $page }}
            </a>
        @endif
    @endfor

    {{-- Last Page --}}
    @if($end < $paginator->lastPage())
        @if($end < $paginator->lastPage() - 1)
            <span class="{{ $sizeClasses }} flex justify-center items-center text-gray-500">...</span>
        @endif
        <a href="{{ $paginator->url($paginator->lastPage()) }}"
           class="{{ $sizeClasses }} flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
           aria-label="Go to page {{ $paginator->lastPage() }}">
            {{ $paginator->lastPage() }}
        </a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="{{ $sizeClasses }} inline-flex justify-center items-center gap-x-1.5 rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 transition-colors duration-150"
           rel="next"
           aria-label="Next page">
            @if($size !== 'small')<span class="hidden sm:inline">{{ $nextText }}</span>@endif
            <i class="ti ti-chevron-right text-sm"></i>
        </a>
    @else
        <span class="{{ $sizeClasses }} inline-flex justify-center items-center gap-x-1.5 rounded-lg text-gray-400 bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:bg-gray-700" aria-disabled="true">
            @if($size !== 'small')<span class="hidden sm:inline">{{ $nextText }}</span>@endif
            <i class="ti ti-chevron-right text-sm"></i>
        </span>
    @endif
</nav>
@endif
