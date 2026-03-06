<div class="menu-item {{ $menu->hasChildren() ? 'has-children' : '' }} @if($menu->isDropdown()) bg-blue-50 @endif">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4 flex-1">
            <!-- Icon & Title -->
            <div class="flex items-center gap-3 flex-1">
                @if ($menu->icon)
                    <i class="ti {{ $menu->icon }} text-xl "></i>
                @else
                    <div class="w-6 h-6 bg-gray-300 rounded"></div>
                @endif
                <div>
                    <p class="font-semibold ">{{ $menu->title }}</p>
                    <p class="text-sm">
                        <span class="px-2 py-1 bg-gray-100 rounded text-xs">
                            {{ $menu->type === 'dropdown' ? 'Dropdown' : 'Item' }}
                        </span>
                        @if ($menu->route)
                            <span class="ml-2 ">{{ $menu->route }}</span>
                        @elseif ($menu->url)
                            <span class="ml-2 ">{{ $menu->url }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Badge -->
            @if ($menu->badge)
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    @if($menu->badge_color === 'red') bg-red-100 text-red-700
                    @elseif($menu->badge_color === 'green') bg-green-100 text-green-700
                    @elseif($menu->badge_color === 'yellow') bg-yellow-100 text-yellow-700
                    @elseif($menu->badge_color === 'orange') bg-orange-100 text-orange-700
                    @elseif($menu->badge_color === 'purple') bg-purple-100 text-purple-700
                    @else bg-blue-100 text-blue-700
                    @endif
                ">
                    {{ $menu->badge }}
                </span>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2 ml-4">
            <a href="{{ route('admin.menus.edit', $menu) }}" class="p-2 hover:bg-gray-200 rounded transition" title="Edit">
                <i class="ti ti-edit "></i>
            </a>
            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 hover:bg-red-100 rounded transition">
                    <i class="ti ti-trash text-red-600"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Children -->
    @if ($menu->children->count() > 0)
        <div class="menu-children">
            @foreach ($menu->children as $child)
                @include('admin.menus.partials.menu-item', ['menu' => $child])
            @endforeach
        </div>
    @endif
</div>
