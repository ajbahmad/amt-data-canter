@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Menu Sidebar</h1>
            <p class="text-gray-500 mt-2">Kelola struktur menu sidebar dengan dropdown dan submenu</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <i class="ti ti-plus"></i>
            Tambah Menu
        </a>
    </div>
</div>

@if (session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
    <i class="ti ti-check text-green-600 mt-1"></i>
    <div>
        <h3 class="font-semibold text-green-900">Berhasil</h3>
        <p class="text-green-700">{{ session('success') }}</p>
    </div>
</div>
@endif

@if (session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
    <i class="ti ti-alert-circle text-red-600 mt-1"></i>
    <div>
        <h3 class="font-semibold text-red-900">Error</h3>
        <p class="text-red-700">{{ session('error') }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <!-- Menu Tree View -->
        <div class="space-y-3" id="menuTree">
            @forelse ($menus as $menu)
                @include('admin.menus.partials.menu-item', ['menu' => $menu])
            @empty
                <div class="text-center py-12">
                    <i class="ti ti-folder-open text-6xl text-gray-300 mx-auto block mb-4"></i>
                    <p class="text-gray-500">Belum ada menu. Mulai dengan membuat menu baru.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .menu-item {
        padding: 12px;
        border-left: 4px solid transparent;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .menu-item:hover {
        background-color: #f3f4f6;
        border-left-color: #3b82f6;
    }

    .dark .menu-item:hover {
        background-color: #374151;
    }

    .menu-item.has-children {
        margin-bottom: 8px;
    }

    .menu-children {
        border-left: 2px solid #e5e7eb;
        margin-left: 16px;
        padding-left: 12px;
        margin-top: 8px;
    }

    .dark .menu-children {
        border-left-color: #4b5563;
    }
</style>
@endsection
