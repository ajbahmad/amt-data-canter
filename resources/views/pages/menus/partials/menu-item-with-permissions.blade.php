@php
    $roleId = $roleId ?? null;
    $permissions = $menu->permissions ?? collect();
    $hasPermission = $permissions->count() > 0;
    $permission = $permissions->first();
@endphp

<div class="menu-item {{ $menu->hasChildren() ? 'has-children' : '' }} @if($menu->isDropdown()) bg-blue-50 @endif">
    <div class="flex {{ $menu->hasChildren() ? 'this-children' : '' }} items-center justify-between gap-4">
        <!-- Menu Info (Left side) -->
        <div class="flex items-center gap-4 flex-1 min-w-0">
            <!-- Icon & Title -->
            <div class="flex items-center gap-3 flex-1 min-w-0">
                @if ($menu->icon)
                    <i class="ti {{ $menu->icon }} text-xl flex-shrink-0"></i>
                @else
                    <div class="w-6 h-6 bg-gray-300 rounded flex-shrink-0"></div>
                @endif
                <div class="min-w-0">
                    <p class="font-bold truncate">{{ $menu->title }}</p>
                    <p class="text-sm flex items-center text-gray-600">
                        <span class="px-2 py-0 bg-blue-100 rounded text-xs whitespace-nowrap">
                            {{ $menu->type }}
                        </span>
                        @if ($menu->route)
                            <span class="ml-2 truncate inline-block max-w-xs">{{ $menu->route }}</span>
                        @elseif ($menu->url)
                            <span class="ml-2 truncate inline-block max-w-xs">{{ $menu->url }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Badge -->
            @if ($menu->badge)
                <span class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap flex-shrink-0
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

        <!-- Permissions Checkboxes (visible when role_id filter is active) -->
        @if($roleId)
            <div class="permission-columns flex gap-4 items-center flex-shrink-0">
                <!-- Create -->
                <div class="permission-cell">
                    <label class="flex items-center gap-2 cursor-pointer" title="Create">
                        <input type="checkbox" 
                               class="permission-checkbox  text-blue-600 focus:ring-blue-500" 
                               data-menu-id="{{ $menu->id }}" 
                               data-action="create"
                               @checked($permission && $permission->can_create)>
                        <span class="text-xs hidden sm:inline">C</span>
                    </label>
                </div>
                <div> | </div>

                <!-- Read -->
                <div class="permission-cell">
                    <label class="flex items-center gap-2 cursor-pointer" title="Read">
                        <input type="checkbox" 
                               class="permission-checkbox text-green-600 focus:ring-green-500" 
                               data-menu-id="{{ $menu->id }}" 
                               data-action="view"
                               @checked($permission && $permission->can_view)>
                        <span class="text-xs hidden sm:inline">R</span>
                    </label>
                </div>
                <div> | </div>


                <!-- Update -->
                <div class="permission-cell">
                    <label class="flex items-center gap-2 cursor-pointer" title="Update">
                        <input type="checkbox" 
                               class="permission-checkbox text-warning focus:ring-warning" 
                               data-menu-id="{{ $menu->id }}" 
                               data-action="edit"
                               @checked($permission && $permission->can_edit)>
                        <span class="text-xs hidden sm:inline">U</span>
                    </label>
                </div>
                <div> | </div>


                <!-- Delete -->
                <div class="permission-cell">
                    <label class="flex items-center gap-2 cursor-pointer" title="Delete">
                        <input type="checkbox" 
                               class="permission-checkbox text-red-600 focus:ring-red-500" 
                               data-menu-id="{{ $menu->id }}" 
                               data-action="delete"
                               @checked($permission && $permission->can_delete)>
                        <span class="text-xs hidden sm:inline">D</span>
                    </label>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center gap-2 ml-4 flex-shrink-0">
            <a href="{{ route('menus.edit', $menu) }}" class="px-2 py-1 hover:bg-gray-200 rounded transition border" title="Edit">
                <i class="ti ti-edit"></i>
            </a>
            <button type="button" class="px-2 py-1 hover:bg-red-100 rounded transition border" title="Delete">
                <i class="ti ti-trash text-red-600"></i>
            </button>
        </div>
    </div>

    <!-- Children -->
    @php
        $children = $menu->childrenRecursiveAll ?? $menu->childrenAll ?? collect();
    @endphp
    @if ($children->count() > 0)
        <div class="menu-children">
            @foreach ($children as $child)
                @include('pages.menus.partials.menu-item-with-permissions', ['menu' => $child, 'roleId' => $roleId])
            @endforeach
        </div>
    @endif
</div>
