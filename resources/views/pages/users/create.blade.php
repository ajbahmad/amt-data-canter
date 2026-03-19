@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Tambah User',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Sistem & Keamanan', 'url' => '#'],
        ['name' => 'User', 'url' => route('users.index')],
        ['name' => 'Tambah Baru', 'url' => '#']
    ]
])

<div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-user mr-2"></i>Nama <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Ahmad Janu">
                @error('name')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-mail mr-2"></i>Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                    placeholder="Contoh: ahmad@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-lock mr-2"></i>Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                    placeholder="Min. 8 karakter (huruf, angka, simbol)">
                @error('password')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimal 8 karakter dengan campuran huruf besar, angka, dan simbol</p>
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-lock mr-2"></i>Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password_confirmation') border-red-500 @enderror"
                    placeholder="Ulangi password">
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Telepon -->
            <div>
                <label for="person_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-user mr-2"></i>Person
                </label>
                <select id="person_id" name="person_id"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('person_id') border-red-500 @enderror">
                    <option value="">-- Pilih Person --</option>
                    @if(isset($persons))
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>
                                {{ $person->full_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('person_id')
                    <p class="mt-2 text-sm text-red-500"><i class="ti ti-alert-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="is_active" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ti ti-circle-check mr-2"></i>Status Aktif
                </label>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-offset-gray-100 dark:bg-gray-700 dark:border-gray-600"
                        {{ old('is_active') ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        User aktif dan dapat login
                    </label>
                </div>
            </div>
        </div>

        <!-- Roles Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="ti ti-badge mr-2"></i>Penugasan Role
            </h3>

            <div id="roles-container" class="space-y-4">
                <div class="role-assignment-group p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ti ti-app-window mr-2"></i>Aplikasi <span class="text-red-500">*</span>
                            </label>
                            <select class="application-select w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                data-index="0">
                                <option value="">-- Pilih Aplikasi --</option>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}" data-app-name="{{ $app->name }}">
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ti ti-badge mr-2"></i>Role <span class="text-red-500">*</span>
                            </label>
                            <select class="role-select w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                name="application_roles[0][]">
                                <option value="">-- Pilih Role --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="add-role-btn" class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                <i class="ti ti-plus mr-2"></i>Tambah Role
            </button>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-gray-700 pt-6">
            <a href="{{ route('users.index') }}"
                class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <i class="ti ti-x mr-2"></i>Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="ti ti-check mr-2"></i>Simpan
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let roleCount = 0;

        // Add role button click handler
        $(document).on('click', '#add-role-btn', function(e) {
            e.preventDefault();
            roleCount++;
            const container = $('#roles-container');
            const newGroup = $(`
                <div class="role-assignment-group p-4 border border-gray-300 dark:border-gray-600 rounded-lg">
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Role ${roleCount + 1}</h4>
                        <button type="button" class="remove-role-btn text-red-500 hover:text-red-700">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ti ti-app-window mr-2"></i>Aplikasi <span class="text-red-500">*</span>
                            </label>
                            <select class="application-select w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                data-index="${roleCount}">
                                <option value="">-- Pilih Aplikasi --</option>
                                @foreach($applications as $app)
                                    <option value="{{ $app->id }}" data-app-name="{{ $app->name }}">
                                        {{ $app->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="ti ti-badge mr-2"></i>Role <span class="text-red-500">*</span>
                            </label>
                            <select class="role-select w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                name="application_roles[${roleCount}][]">
                                <option value="">-- Pilih Role --</option>
                            </select>
                        </div>
                    </div>
                </div>
            `);

            container.append(newGroup);
        });

        // Remove role button click handler (event delegation)
        $(document).on('click', '.remove-role-btn', function(e) {
            e.preventDefault();
            $(this).closest('.role-assignment-group').remove();
        });

        // Application select change handler (event delegation)
        $(document).on('change', '.application-select', function() {
            const applicationId = $(this).val();
            const roleSelect = $(this).closest('.role-assignment-group').find('.role-select');
            
            if (!applicationId) {
                roleSelect.prop('disabled', true);
                roleSelect.html('<option value="">-- Pilih Role --</option>');
                return;
            }

            // Fetch roles for this application
            $.ajax({
                url: `{{ route('roles.index') }}?application_id=${applicationId}`,
                type: 'GET',
                dataType: 'json',
                success: function(roles) {
                    roleSelect.prop('disabled', false);
                    roleSelect.html('<option value="">-- Pilih Role --</option>');
                    $.each(roles, function(index, role) {
                        roleSelect.append(`<option value="${role.id}">${role.name}</option>`);
                    });
                },
                error: function(error) {
                    console.error('Error loading roles:', error);
                }
            });
        });
    });
</script>
@endpush
