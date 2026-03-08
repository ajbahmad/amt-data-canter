@php
use App\Helpers\MenuHelper;

// Default depth to 0 if not provided
$depth = $depth ?? 0;
$maxDepth = 10; // Prevent infinite recursion

// Determine if this is a single item or dropdown
$isSingleItem = $menu['type'] === 'single';
$hasChildren = !empty($menu['children']) && is_array($menu['children']);

// Get styling based on depth
$paddingClass = match($depth) {
    0 => 'ps-0',
    1 => 'ps-4',
    2 => 'ps-8',
    3 => 'ps-12',
    4 => 'ps-16',
    default => 'ps-20',
};

$textSizeClass = match($depth) {
    0 => 'text-sm',
    1 => 'text-xs',
    default => 'text-xs',
};
@endphp

@if($depth > $maxDepth)
    {{-- Safety check: stop rendering if depth exceeds max --}}
@elseif($isSingleItem || !$hasChildren)
    {{-- Single menu item (leaf node) --}}
    @php
        $isMenuActive = MenuHelper::isActive($menu);
    @endphp
    <li class="sidebar-item {{ $depth > 0 ? 'dropdown-submenu' : '' }}">
        <a class="sidebar-link {{ $depth === 0 ? MenuHelper::getColorClass($menu['color'], 'background') . ' ' . MenuHelper::getColorClass($menu['color'], 'hover') : 'textlink dark:opacity-70' }} {{ $isMenuActive ? 'active text-' . $menu['color'] . ' dark:text-' . $menu['color'] . ($depth > 0 ? ' font-semibold' : '') : '' }} {{ $paddingClass }} {{ $textSizeClass }}"
            href="{{ MenuHelper::getRouteUrl($menu['route']) }}">
            <i class="text-lg {{ $menu['icon'] }}"></i>
            <span class="hide-menu flex-shrink-0">{{ $menu['title'] }}</span>
        </a>
    </li>
@else
    {{-- Dropdown menu item (parent with children) --}}
    @php
        $hasActiveChild = MenuHelper::hasActiveChild($menu);
        $accordionId = $menu['id'] ?? 'menu-' . uniqid();
        $contentId = str_replace('-accordion', '-content', $accordionId);
    @endphp
    <li class="hs-accordion sidebar-item {{ $depth > 0 ? 'dropdown-submenu' : '' }} {{ $hasActiveChild ? 'active' : '' }}" id="{{ $accordionId }}">
        <a class="cursor-pointer hs-accordion-toggle sidebar-link {{ $depth === 0 ? MenuHelper::getColorClass($menu['color'], 'background') . ' ' . MenuHelper::getColorClass($menu['color'], 'hover') : 'textlink dark:opacity-70' }} {{ $hasActiveChild ? 'active text-' . $menu['color'] . ' dark:text-' . $menu['color'] : '' }} {{ $paddingClass }} {{ $textSizeClass }}">
            <i class="text-lg {{ $menu['icon'] }}"></i>
            <span class="hide-menu">{{ $menu['title'] }}</span>
            @if($depth === 0)
                <span class="hide-menu ms-auto">
                    <i class="ti ti-chevron-right text-lg me-4 leading-tight hs-accordion-active:hidden"></i>
                    <i class="ti ti-chevron-up text-lg ms-auto hs-accordion-active:block hidden z-10 relative me-4"></i>
                </span>
            @else
                <span class="hide-menu ms-auto">
                    <i class="ti ti-chevron-right text-xs me-2 leading-tight hs-accordion-active:hidden"></i>
                    <i class="ti ti-chevron-up text-xs ms-auto hs-accordion-active:block hidden z-10 relative me-2"></i>
                </span>
            @endif
        </a>
        <div id="{{ $contentId }}" class="hs-accordion-content {{ $hasActiveChild ? 'hs-accordion-active' : '' }}">
            <ul class="hs-accordion-group">
                @foreach($menu['children'] as $childMenu)
                    @include('components.admin.menu-item-recursive', ['menu' => $childMenu, 'depth' => $depth + 1])
                @endforeach
            </ul>
        </div>
    </li>
@endif
