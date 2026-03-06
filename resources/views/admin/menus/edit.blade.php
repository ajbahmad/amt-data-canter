@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Edit Menu</h1>
    <p class="text-gray-500 mt-2">{{ $menu->title }}</p>
</div>

<div class="grid grid-cols-3 gap-6">
    <!-- Form Column -->
    <div class="col-span-2">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
                <!-- Tipe Menu -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Tipe Menu <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="item" class="w-4 h-4" {{ $menu->type === 'item' ? 'checked' : '' }} onchange="updateTypeUI()">
                            <span class="text-gray-700">Item (Punya route/url)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="dropdown" class="w-4 h-4" {{ $menu->type === 'dropdown' ? 'checked' : '' }} onchange="updateTypeUI()">
                            <span class="text-gray-700">Dropdown (Punya submenu)</span>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul Menu -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                        Judul Menu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $menu->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror" placeholder="Contoh: Master Data, Laporan, Dashboard">
                    @error('title')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Menu -->
                <div>
                    <label for="parent_id" class="block text-sm font-semibold text-gray-900 mb-2">
                        Menu Parent (Opsional)
                    </label>
                    <select id="parent_id" name="parent_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500 @error('parent_id') border-red-500 @enderror">
                        <option value="">-- Pilih Parent Menu --</option>
                        @foreach ($parentMenus as $id => $title)
                            <option value="{{ $id }}" {{ old('parent_id', $menu->parent_id) === $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-semibold text-gray-900 mb-2">
                        Icon (Opsional)
                    </label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $menu->icon) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: solar:book-bookmark-line-duotone, ti-home">
                    <p class="text-gray-500 text-xs mt-1">Icon dari tabler icons atau solar icons</p>
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-semibold text-gray-900 mb-2">
                        Warna Label
                    </label>
                    <select id="color" name="color" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                        <option value="blue" {{ old('color', $menu->color) === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="indigo" {{ old('color', $menu->color) === 'indigo' ? 'selected' : '' }}>Indigo</option>
                        <option value="purple" {{ old('color', $menu->color) === 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="pink" {{ old('color', $menu->color) === 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="red" {{ old('color', $menu->color) === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="orange" {{ old('color', $menu->color) === 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="yellow" {{ old('color', $menu->color) === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="green" {{ old('color', $menu->color) === 'green' ? 'selected' : '' }}>Green</option>
                    </select>
                </div>

                <!-- Route (untuk item) -->
                <div id="routeField" class="{{ $menu->type === 'dropdown' ? 'hidden' : '' }}">
                    <label for="route" class="block text-sm font-semibold text-gray-900 mb-2">
                        Route <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="route" name="route" value="{{ old('route', $menu->route) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500 @error('route') border-red-500 @enderror" placeholder="Contoh: admin.students.index">
                    @error('route')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- URL (untuk item) -->
                <div id="urlField" class="{{ $menu->type === 'dropdown' ? 'hidden' : '' }}">
                    <label for="url" class="block text-sm font-semibold text-gray-900 mb-2">
                        URL (Alternatif)
                    </label>
                    <input type="url" id="url" name="url" value="{{ old('url', $menu->url) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500 @error('url') border-red-500 @enderror" placeholder="Contoh: https://example.com/admin">
                    @error('url')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Menu Key (untuk dropdown) -->
                <div id="menuKeyField" class="{{ $menu->type === 'item' ? 'hidden' : '' }}">
                    <label for="menu_key" class="block text-sm font-semibold text-gray-900 mb-2">
                        Menu Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="menu_key" name="menu_key" value="{{ old('menu_key', $menu->menu_key) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500 @error('menu_key') border-red-500 @enderror" placeholder="Contoh: master-data, academic">
                    @error('menu_key')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="order_no" class="block text-sm font-semibold text-gray-900 mb-2">
                        Urutan Tampil
                    </label>
                    <input type="number" id="order_no" name="order_no" value="{{ old('order_no', $menu->order_no) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
                    <p class="text-gray-500 text-xs mt-1">Semakin kecil, semakin atas</p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea id="description" name="description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi menu untuk tooltip">{{ old('description', $menu->description) }}</textarea>
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-semibold text-gray-900 mb-2">
                        Badge (Opsional)
                    </label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $menu->badge) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: NEW, 5, Hot">
                </div>

                <!-- Badge Color -->
                <div>
                    <label for="badge_color" class="block text-sm font-semibold text-gray-900 mb-2">
                        Warna Badge
                    </label>
                    <select id="badge_color" name="badge_color" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:ring-blue-500 focus:border-blue-500">
                        <option value="blue" {{ old('badge_color', $menu->badge_color) === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="red" {{ old('badge_color', $menu->badge_color) === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="green" {{ old('badge_color', $menu->badge_color) === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="yellow" {{ old('badge_color', $menu->badge_color) === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="orange" {{ old('badge_color', $menu->badge_color) === 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="purple" {{ old('badge_color', $menu->badge_color) === 'purple' ? 'selected' : '' }}>Purple</option>
                    </select>
                </div>

                <!-- Aktif -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_active" name="is_active" value="1" class="w-5 h-5 rounded" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="text-gray-700">Aktif</label>
                </div>
            </div>

            <!-- Permissions Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Izin Akses (Opsional)</h2>
                <p class="text-gray-600 text-sm mb-4">Tentukan role mana saja yang bisa melihat menu ini. Jika kosong, semua role bisa akses.</p>

                <div class="space-y-3" id="permissionsContainer">
                    @foreach ($permissions as $permission)
                        <div class="flex items-end gap-3 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <label class="block text-sm font-semibold text-gray-900 mb-1">Role</label>
                                <select name="permissions[][role_code]" class="w-full px-3 py-2 border border-gray-300 rounded bg-white text-gray-900">
                                    @foreach ($availableRoles as $code => $label)
                                        <option value="{{ $code }}" {{ $permission->role_code === $code ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[][can_view]" value="1" class="w-4 h-4" {{ $permission->can_view ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">Lihat</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[][can_create]" value="1" class="w-4 h-4" {{ $permission->can_create ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">Buat</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[][can_edit]" value="1" class="w-4 h-4" {{ $permission->can_edit ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">Edit</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="permissions[][can_delete]" value="1" class="w-4 h-4" {{ $permission->can_delete ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">Hapus</span>
                                </label>
                            </div>

                            <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-600 hover:bg-red-100 rounded">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="addPermissionRow()" class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    + Tambah Role
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Column -->
    <div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sticky top-6">
            <h3 class="font-semibold text-blue-900 mb-3">💡 Panduan</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex gap-2">
                    <span class="flex-shrink-0">•</span>
                    <span><strong>Item:</strong> Menu yang direct ke page/route</span>
                </li>
                <li class="flex gap-2">
                    <span class="flex-shrink-0">•</span>
                    <span><strong>Dropdown:</strong> Menu yang punya submenu</span>
                </li>
                <li class="flex gap-2">
                    <span class="flex-shrink-0">•</span>
                    <span><strong>Route:</strong> Wajib jika tipe Item</span>
                </li>
                <li class="flex gap-2">
                    <span class="flex-shrink-0">•</span>
                    <span><strong>Menu Key:</strong> Wajib jika tipe Dropdown</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    function updateTypeUI() {
        const type = document.querySelector('input[name="type"]:checked').value;
        const routeField = document.getElementById('routeField');
        const urlField = document.getElementById('urlField');
        const menuKeyField = document.getElementById('menuKeyField');
        const route = document.getElementById('route');
        const menuKey = document.getElementById('menu_key');

        if (type === 'item') {
            routeField.classList.remove('hidden');
            urlField.classList.remove('hidden');
            menuKeyField.classList.add('hidden');
            route.required = true;
            menuKey.required = false;
        } else {
            routeField.classList.add('hidden');
            urlField.classList.add('hidden');
            menuKeyField.classList.remove('hidden');
            route.required = false;
            menuKey.required = true;
        }
    }

    function addPermissionRow() {
        const container = document.getElementById('permissionsContainer');
        const rowHtml = `
            <div class="flex items-end gap-3 p-4 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Role</label>
                    <select name="permissions[][role_code]" class="w-full px-3 py-2 border border-gray-300 rounded bg-white text-gray-900">
                        @foreach ($availableRoles as $code => $label)
                            <option value="{{ $code }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="permissions[][can_view]" value="1" class="w-4 h-4" checked>
                        <span class="text-sm text-gray-700">Lihat</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="permissions[][can_create]" value="1" class="w-4 h-4">
                        <span class="text-sm text-gray-700">Buat</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="permissions[][can_edit]" value="1" class="w-4 h-4">
                        <span class="text-sm text-gray-700">Edit</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="permissions[][can_delete]" value="1" class="w-4 h-4">
                        <span class="text-sm text-gray-700">Hapus</span>
                    </label>
                </div>

                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-600 hover:bg-red-100 rounded">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTypeUI();
    });
</script>
@endsection
