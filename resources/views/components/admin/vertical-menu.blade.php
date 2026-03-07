@php
use App\Helpers\MenuHelper;
$sections = MenuHelper::getVerticalMenuSections();
@endphp

<nav class="hs-accordion-group w-full flex flex-col">
    <ul data-te-sidenav-menu-ref id="sidebarnav">
        @foreach($sections as $section)

            @if($section['title'] !== 'DASHBOARD')
                <!-----{{ $section['title'] }}------->
                <div class="caption">
                    <i class="ti ti-dots nav-small-cap-icon text-lg hidden text-center leading-[16px]"></i>
                    <span class="hide-menu">{{ $section['title'] }}</span>
                </div>
            @endif

            @foreach($section['items'] as $menu)
                @if($menu['type'] === 'single')
                    @php
                        $isMenuActive = MenuHelper::isActive($menu);
                    @endphp
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ MenuHelper::getColorClass($menu['color'], 'background') }} {{ MenuHelper::getColorClass($menu['color'], 'hover') }} {{ $isMenuActive ? 'active text-' . $menu['color'] . ' dark:text-' . $menu['color'] : '' }}"
                            href="{{ MenuHelper::getRouteUrl($menu['route']) }}">
                            <i class="text-xl {{ $menu['icon'] }}"></i>
                            <span class="hide-menu flex-shrink-0">{{ $menu['title'] }} </span>
                        </a>
                    </li>
                @elseif($menu['type'] === 'dropdown')
                    @php
                        $hasActiveChild = MenuHelper::hasActiveChild($menu);
                    @endphp
                    <li class="hs-accordion sidebar-item {{ $hasActiveChild ? 'active' : '' }}" id="{{ $menu['id'] }}">
                        <a class="cursor-pointer hs-accordion-toggle sidebar-link {{ MenuHelper::getColorClass($menu['color'], 'background') }} {{ MenuHelper::getColorClass($menu['color'], 'hover') }} {{ $hasActiveChild ? 'active text-' . $menu['color'] . ' dark:text-' . $menu['color'] : '' }}">
                            <i class="text-xl {{ $menu['icon'] }}"></i>
                            <span class="hide-menu">{{ $menu['title'] }}</span>
                            <span class="hide-menu ms-auto">
                                <i class="ti ti-chevron-right text-lg me-4 leading-tight hs-accordion-active:hidden"></i>
                                <i class="ti ti-chevron-up text-lg ms-auto hs-accordion-active:block hidden z-10 relative me-4"></i>
                            </span>
                        </a>
                        <div id="{{ str_replace('-accordion', '-content', $menu['id']) }}" class="hs-accordion-content {{ $hasActiveChild ? 'hs-accordion-active' : '' }}">
                            <ul class="hs-accordion-group">
                                @foreach($menu['children'] as $child)
                                    @php
                                        $isChildActive = MenuHelper::isActive($child);
                                    @endphp
                                    <li class="dropdown-submenu">
                                        <a class="hs-accordion-toggle textlink dark:opacity-70 {{ $isChildActive ? 'active text-' . $menu['color'] . ' dark:text-' . $menu['color'] . ' font-semibold' : '' }}" href="{{ MenuHelper::getRouteUrl($child['route']) }}">
                                            <i class="text-xl {{ $child['icon'] }}"></i>
                                            <span class="hide-menu">{{ $child['title'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        @endforeach
    </ul>
</nav>
