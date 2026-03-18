@extends('layouts.admin')

@section('title', 'Edit Peran')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Peran',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'IAM', 'url' => '#'],
        ['name' => 'Peran', 'url' => route('roles.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Aplikasi -->
            <div>
                <label for="application_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-app-window mr-2"></i>Aplikasi <span class="text-red-500">*</span>
                </label>
                <select id="application_id" name="application_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('application_id') border-red-500 @enderror">
                    <option value="">-- Pilih Aplikasi --</option>
                    @foreach($applications as $app)
                        <option value="{{ $app->id }}" {{ old('application_id', $role->application_id) == $app->id ? 'selected' : '' }}>
                            {{ $app->name }}
                        </option>
                    @endforeach
                </select>
                @error('application_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Peran -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-badge mr-2"></i>Nama Peran <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Administrator">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-tag mr-2"></i>Slug <span class="text-red-500">*</span>
                </label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $role->slug) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('slug') border-red-500 @enderror"
                    placeholder="Contoh: admin">
                @error('slug')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Prioritas -->
            <div>
                <label for="priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-sort-ascending mr-2"></i>Prioritas
                </label>
                <input type="number" id="priority" name="priority" value="{{ old('priority', $role->priority) }}" min="0"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('priority') border-red-500 @enderror"
                    placeholder="0">
                @error('priority')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-file-text mr-2"></i>Deskripsi
            </label>
            <textarea id="description" name="description" rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('description') border-red-500 @enderror"
                placeholder="Masukkan deskripsi peran">{{ old('description', $role->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <!-- Cakupan -->
        <div>
            <label for="scope" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                <i class="ti ti-world mr-2"></i>Cakupan <span class="text-red-500">*</span>
            </label>
            <select id="scope" name="scope" required
                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('scope') border-red-500 @enderror"
                onchange="toggleScopeFields()">
                <option value="">-- Pilih Cakupan --</option>
                <option value="global" {{ old('scope', $role->scope) == 'global' ? 'selected' : '' }}>Global (Semua Akses)</option>
                <option value="institution" {{ old('scope', $role->scope) == 'institution' ? 'selected' : '' }}>Lembaga (Spesifik Lembaga)</option>
                <option value="school" {{ old('scope', $role->scope) == 'school' ? 'selected' : '' }}>Sekolah (Spesifik Tingkat)</option>
            </select>
            @error('scope')
                <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
            @enderror
        </div>

        <!-- Conditional Fields -->
        <div id="scope-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Lembaga -->
            <div id="institution-field" style="display: none;">
                <label for="school_institution_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-building mr-2"></i>Lembaga
                </label>
                <select id="school_institution_id" name="school_institution_id"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('school_institution_id') border-red-500 @enderror">
                    <option value="">-- Pilih Lembaga --</option>
                    @foreach($institutions as $inst)
                        <option value="{{ $inst->id }}" {{ old('school_institution_id', $role->school_institution_id) == $inst->id ? 'selected' : '' }}>
                            {{ $inst->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_institution_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Tingkat Sekolah -->
            <div id="school-level-field" style="display: none;">
                <label for="school_level_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-building-community mr-2"></i>Tingkat Sekolah
                </label>
                <select id="school_level_id" name="school_level_id"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('school_level_id') border-red-500 @enderror">
                    <option value="">-- Pilih Tingkat --</option>
                    @foreach($schoolLevels as $level)
                        <option value="{{ $level->id }}" {{ old('school_level_id', $role->school_level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->name }}
                        </option>
                    @endforeach
                </select>
                @error('school_level_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="space-y-3 border-t border-gray-200 dark:border-gray-700 pt-6">
            <!-- Sistem -->
            <div class="flex items-center">
                <input type="checkbox" id="is_system" name="is_system" value="1" {{ old('is_system', $role->is_system) ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <label for="is_system" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                    Peran Sistem (tidak dapat dihapus)
                </label>
            </div>

            <!-- Aktif -->
            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $role->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer">
                    Aktif
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('roles.index') }}" class="inline-flex items-center px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                <i class="ti ti-check mr-2"></i>Perbarui
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
    @include('components.confirm-toastr')
    <script>
        function toggleScopeFields() {
            const scope = document.getElementById('scope').value;
            const institutionField = document.getElementById('institution-field');
            const schoolLevelField = document.getElementById('school-level-field');
            
            institutionField.style.display = (scope === 'institution' || scope === 'school') ? 'block' : 'none';
            schoolLevelField.style.display = (scope === 'school') ? 'block' : 'none';
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleScopeFields);
    </script>
@endpush
