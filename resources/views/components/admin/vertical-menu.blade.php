@php
use App\Helpers\MenuHelper;
$sections = MenuHelper::getVerticalMenuSections();
@endphp

<nav class="hs-accordion-group w-full flex flex-col">
    <ul data-te-sidenav-menu-ref id="sidebarnav">
        @foreach($sections as $section)

            @foreach($section['items'] as $menu)
                @include('components.admin.menu-item-recursive', ['menu' => $menu, 'depth' => 0])
            @endforeach
        @endforeach
    </ul>
</nav>
