@php
use App\Helpers\MenuHelper;
$dashboardMenu = collect(MenuHelper::getAllMenus())->first(function($menu) {
    return str_contains(strtolower($menu['title']), 'dashboard');
});
$groups = MenuHelper::getHorizontalMenuGroups();
@endphp

<nav class="relative py-4">
    <div class="container">
        <div class="flex gap-6 items-center relative">

            <!-- Dashboard -->
            @if($dashboardMenu)
            <a class="single-link-horizontal font-medium item-horizontal {{ MenuHelper::getColorClass($dashboardMenu['color'], 'background') }} {{ MenuHelper::getColorClass($dashboardMenu['color'], 'hover') }} {{ MenuHelper::isActive($dashboardMenu) ? 'hs-accordion-active active text-' . $dashboardMenu['color'] . ' dark:text-' . $dashboardMenu['color'] : '' }}"
                href="{{ MenuHelper::getRouteUrl($dashboardMenu['route']) }}">
                <iconify-icon icon="{{ $dashboardMenu['icon'] }}" class="text-xl p-2"></iconify-icon>
                {{ $dashboardMenu['title'] }}
            </a>
            @endif

            <!-- Menu Groups -->
            @foreach($groups as $groupKey => $group)
            <div class="hs-dropdown [--strategy:static] lg:[--strategy:absolute] md:[--trigger:hover] [--adaptive:none] relative">
                <button type="button"
                    class="single-link-horizontal font-medium item-horizontal {{ MenuHelper::getColorClass($group['color'], 'background') }} {{ MenuHelper::getColorClass($group['color'], 'hover') }}">
                    <iconify-icon icon="{{ $group['icon'] }}" class="text-xl p-2"></iconify-icon>
                    {{ $group['title'] }}<i class="ti ti-chevron-down ms-auto text-md"></i>
                </button>
                <div class="py-4 px-3 hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 left-0 hidden z-10 sm:mt-4 top-full start-0 min-w-96 before:absolute lg:bg-white bg-transparent dark:bg-dark lg:shadow-md shadow-none">

                    @if(count($group['items']) > 6)
                        {{-- Use grid layout for many items --}}
                        <div class="grid grid-cols-12">
                            @foreach($group['items'] as $menu)
                                <div class="col-span-6">
                                    @if($menu['type'] === 'single')
                                        <a class="dropdown-link-horizontal" href="{{ MenuHelper::getRouteUrl($menu['route']) }}">
                                            <iconify-icon icon="{{ $menu['icon'] }}" class="text-base flex-shrink-0"></iconify-icon>
                                            <span class="hide-menu flex-shrink-0 text-sm leading-tight">{{ $menu['title'] }}</span>
                                        </a>
                                    @elseif($menu['type'] === 'dropdown')
                                        {{-- For dropdown items in horizontal, show as expandable --}}
                                        <div class="dropdown-header">
                                            <iconify-icon icon="{{ $menu['icon'] }}" class="text-base flex-shrink-0"></iconify-icon>
                                            <span class="hide-menu flex-shrink-0 text-sm leading-tight font-medium">{{ $menu['title'] }}</span>
                                        </div>
                                        @foreach($menu['children'] as $child)
                                            <a class="dropdown-link-horizontal ml-4" href="{{ MenuHelper::getRouteUrl($child['route']) }}">
                                                <i class="ti ti-circle text-xs flex-shrink-0"></i>
                                                <span class="hide-menu flex-shrink-0 text-xs leading-tight">{{ $child['title'] }}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Use simple list layout for few items --}}
                        @foreach($group['items'] as $menu)
                            @if($menu['type'] === 'single')
                                <a class="dropdown-link-horizontal" href="{{ MenuHelper::getRouteUrl($menu['route']) }}">
                                    <iconify-icon icon="{{ $menu['icon'] }}" class="text-base flex-shrink-0"></iconify-icon>
                                    <span class="hide-menu flex-shrink-0 text-sm leading-tight">{{ $menu['title'] }}</span>
                                </a>
                            @elseif($menu['type'] === 'dropdown')
                                {{-- For dropdown items in horizontal, show as expandable --}}
                                <div class="dropdown-header mb-2">
                                    <iconify-icon icon="{{ $menu['icon'] }}" class="text-base flex-shrink-0"></iconify-icon>
                                    <span class="hide-menu flex-shrink-0 text-sm leading-tight font-medium">{{ $menu['title'] }}</span>
                                </div>
                                @foreach($menu['children'] as $child)
                                    <a class="dropdown-link-horizontal ml-4" href="{{ MenuHelper::getRouteUrl($child['route']) }}">
                                        <i class="ti ti-circle text-xs flex-shrink-0"></i>
                                        <span class="hide-menu flex-shrink-0 text-xs leading-tight">{{ $child['title'] }}</span>
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach

        </div>
    </div>
</nav>

<style>
.dropdown-header {
    @apply flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700 mb-1;
}
.dropdown-link-horizontal.ml-4 {
    @apply pl-8;
}
</style>
