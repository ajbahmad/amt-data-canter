@props([
    'id' => 'modal',
    'title' => 'Modal Title',
    'size' => 'lg', // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, full
    'scrollable' => true,
    'closable' => true,
    'backdrop' => true, // Allow closing by clicking backdrop
    'keyboard' => true, // Allow closing with ESC key
    'centered' => true,
    'static' => false, // Prevent closing modal
    'zIndex' => 'z-[80]',
    'maxHeight' => '70vh', // For scrollable content
    'showHeader' => true,
    'showFooter' => false,
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
])

@php
    $sizeClasses = [
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'lg:max-w-lg',
        'xl' => 'lg:max-w-xl',
        '2xl' => 'lg:max-w-2xl',
        '3xl' => 'lg:max-w-3xl',
        '4xl' => 'lg:max-w-4xl',
        '5xl' => 'lg:max-w-5xl',
        '6xl' => 'lg:max-w-6xl',
        '7xl' => 'lg:max-w-7xl',
        'full' => 'max-w-full',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['lg'];
    $backdropAttr = $backdrop ? '' : 'data-hs-overlay-backdrop="false"';
    $keyboardAttr = $keyboard ? '' : 'data-hs-overlay-keyboard="false"';
    $staticAttr = $static ? 'data-hs-overlay-backdrop="static"' : '';
@endphp

<div id="{{ $id }}"
     class="hs-overlay hidden size-full fixed top-0 start-0 {{ $zIndex }} overflow-x-hidden overflow-y-auto pointer-events-none"
     {{ $backdropAttr }}
     {{ $keyboardAttr }}
     {{ $staticAttr }}>

    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all {{ $sizeClass }} lg:w-full m-3 lg:mx-auto {{ $centered ? 'min-h-[calc(100%-3.5rem)] flex items-center' : '' }}">

        <div class="flex flex-col bg-white border rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7] w-full shadow-lg {{ $attributes->get('class', '') }}">

            {{-- Header --}}
            @if($showHeader)
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700 {{ $headerClass }}">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                        {{ $title }}
                    </h3>

                    @if($closable)
                        <button type="button"
                            class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-gray-600 dark:focus:ring-offset-gray-800"
                            data-hs-overlay="#{{ $id }}"
                            aria-label="Close modal">
                            <span class="sr-only">Close</span>
                            <i class="ti ti-x text-xl"></i>
                        </button>
                    @endif
                </div>
            @endif

            {{-- Body --}}
            <div class="{{ $scrollable ? 'overflow-y-auto' : '' }} {{ $scrollable && $maxHeight ? 'max-h-[' . $maxHeight . ']' : '' }} {{ $bodyClass }}">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if($showFooter && isset($footer))
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700 {{ $footerClass }}">
                    {{ $footer }}
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Optional JavaScript for enhanced functionality --}}
@once
    @push('scripts')
    <script>
        // Enhanced modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-initialize Preline UI overlays
            if (window.HSOverlay) {
                window.HSOverlay.autoInit();
            }

            // Add keyboard support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    // Close any open modals with keyboard support
                    const openModals = document.querySelectorAll('.hs-overlay:not(.hidden)');
                    openModals.forEach(modal => {
                        if (!modal.hasAttribute('data-hs-overlay-keyboard') || modal.getAttribute('data-hs-overlay-keyboard') !== 'false') {
                            window.HSOverlay?.close(modal);
                        }
                    });
                }
            });

            // Add backdrop click support
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('hs-overlay') &&
                    !e.target.hasAttribute('data-hs-overlay-backdrop') ||
                    e.target.getAttribute('data-hs-overlay-backdrop') !== 'false') {
                    if (!e.target.hasAttribute('data-hs-overlay-backdrop') ||
                        e.target.getAttribute('data-hs-overlay-backdrop') !== 'static') {
                        window.HSOverlay?.close(e.target);
                    }
                }
            });
        });

        // Utility functions for modal control
        window.modalUtils = {
            open: function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal && window.HSOverlay) {
                    window.HSOverlay.open(modal);
                }
            },

            close: function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal && window.HSOverlay) {
                    window.HSOverlay.close(modal);
                }
            },

            toggle: function(modalId) {
                const modal = document.getElementById(modalId);
                if (modal && window.HSOverlay) {
                    if (modal.classList.contains('hidden')) {
                        window.HSOverlay.open(modal);
                    } else {
                        window.HSOverlay.close(modal);
                    }
                }
            }
        };
    </script>
    @endpush
@endonce
