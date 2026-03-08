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
                @include('components.admin.menu-item-recursive', ['menu' => $menu, 'depth' => 0])
            @endforeach
        @endforeach
    </ul>
</nav>
