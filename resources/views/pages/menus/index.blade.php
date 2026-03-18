@extends('layouts.admin')

@section('title', 'Manajemen Menu')

@section('content')
    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Manajemen Menu & Permission',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Sistem & Keamanan', 'url' => '#'],
            ['name' => 'Menu & Permission', 'url' => '#'],
        ],
    ])
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Menu & Permission</h1>
                    <p class="text-gray-500 mt-2">Kelola struktur menu sidebar dan role permissions</p>
                </div>
                <a href="{{ route('menus.create') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="ti ti-plus"></i>
                    Tambah Menu
                </a>
            </div>
        </div>
        <hr>
        <h2 class="text-lg font-semibold pt-4 mb-2">Filter</h2>
        <form method="GET" action="{{ route('menus.index') }}" class="flex gap-4 flex-wrap items-end">
            <!-- Filter Aplikasi -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Aplikasi</label>
                <select name="application_id" 
                    id="application_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Semua Aplikasi --</option>
                    @foreach ($applications as $app)
                        <option value="{{ $app->id }}" @selected(request('application_id') == $app->id)>
                            {{ $app->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Role -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Role (untuk Permission)</label>
                <select name="role_id"
                    id="role_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="ti ti-filter"></i> Filter
            </button>

            @if (request('application_id') || request('role_id'))
                <a href="{{ route('menus.index') }}"
                    class="px-5 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="ti ti-x"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Menu List dengan Permissions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form id="permissionsForm" class="space-y-3" data-url="{{ route('menus.update_permissions') }}">
                @csrf
                <input type="hidden" name="role_id" value="{{ request('role_id') }}">
                <input type="hidden" name="application_id" value="{{ request('application_id') }}">

                @if (request('role_id') && request('application_id'))
                    <div class="text-right" style="padding-right: 48px">
                        <input type="checkbox" id="selectAll" class="cursor-pointer">
                        <label for="selectAll" class="text-sm cursor-pointer">Select All</label>
                    </div>
                @endif


                <!-- Menu Tree View -->
                <div class="space-y-3" id="menuTree">

                    @if (request('role_id') && request('application_id'))
                        <div class="menu-items" style="padding-right: 48px">
                            <div class="flex items-center justify-between gap-4">
                                <!-- Menu Info (Left side) -->

                                <!-- Permissions Checkboxes (visible when role_id filter is active) -->
                                <div class="ms-auto flex gap-2 items-center flex-shrink-0">
                                    <!-- Create -->
                                    <div><span class="text-primary font-bold">C</span>reate </div>
                                    <div>|</div>

                                    <!-- Read -->
                                    <div><span class="text-success font-bold">R</span>ead </div>
                                    <div>|</div>

                                    <!-- Update -->
                                    <div><span class="text-warning font-bold">U</span>pdate </div>
                                    <div>|</div>

                                    <!-- Delete -->
                                    <div><span class="text-red-600 font-bold">D</span>elete </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 ml-4 flex-shrink-0"> Opsi </div>
                            </div>
                        </div>
                    @endif



                    @forelse ($menus as $menu)
                        @include('pages.menus.partials.menu-item-with-permissions', [
                            'menu' => $menu,
                            'roleId' => request('role_id'),
                        ])
                    @empty
                        <div class="text-center py-12">
                            <i class="ti ti-folder-open text-6xl text-gray-300 mx-auto block mb-4"></i>
                            <p class="text-gray-500">Belum ada menu. Mulai dengan membuat menu baru.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Save Changes Button -->
                @if (request('role_id') && request('application_id'))
                    <div class="mt-8 pt-6 border-t border-gray-200 flex gap-3 justify-end sticky bottom-0 bg-white">
                        <button type="button"
                            class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
                            onclick="window.location.reload()">
                            <i class="ti ti-x"></i> Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-success text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                            <i class="ti ti-check"></i> Simpan Perubahan
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <style>
        .menu-item {
            padding: 12px;
            padding-right: 48px;
            border-left: 4px solid transparent;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .menu-item.has-children {
            padding-right: 24px;
        }

        .menu-item .menu-item {
            padding-right: 24px;
        }

        .menu-item.has-children .this-children {
            padding-right: 24px;
        }

        .menu-item.has-children .menu-item.has-children .this-children {
            padding-right: 12px;
        }

        .menu-item.has-children .menu-item.has-children {
            padding-right: 12px;
        }

        .menu-item .menu-item .menu-item {
            padding-right: 12px;
        }

        .menu-item:hover {
            background-color: #f3f4f6;
            border-left-color: #3b82f6;
        }

        .menu-item .menu-item:hover {
            background-color: #fff;
        }

        .menu-item .menu-item .menu-item:hover {
            background-color: #f3f4f6;
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

        .permission-checkbox {
            w-4 h-4 text-blue-600 rounded border-gray-300 focus: ring-2 focus:ring-blue-500
        }

        .permission-cell {
            text-center
        }

        @media (max-width: 1024px) {
            .permission-columns {
                display: none;
            }
        }
    </style>

    
@endsection


@push('scripts')
@include('components.confirm-toastr')

<script>
        $(document).ready(function() {
            // Select All functionality
            $('#selectAll').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('#permissionsForm input[type="checkbox"][data-menu-id]').prop('checked', isChecked);
            });

            // Form submission with jQuery
            $('#permissionsForm').on('submit', function(e) {
                e.preventDefault();

                console.log('submit');
                
                const $form = $(this);
                const formUrl = $form.data('url');

                // Show loading state
                const $submitBtn = $form.find('button[type="submit"]');
                const originalText = $submitBtn.html();
                $submitBtn.prop('disabled', true).html('<i class="ti ti-loader-3 animate-spin"></i> Menyimpan...');

                // Collect permissions data
                const permissions = [];
                const checkboxes = $form.find('input[type="checkbox"][data-menu-id]');

                checkboxes.each(function() {
                    const $checkbox = $(this);
                    const menuId = $checkbox.data('menu-id');
                    const action = $checkbox.data('action');

                    // Find if this menu already in permissions array
                    let permission = permissions.find(p => p.menu_id === menuId);
                    if (!permission) {
                        permission = {
                            menu_id: menuId,
                            role_id: '{{ request('role_id') }}',
                            can_view: false,
                            can_create: false,
                            can_edit: false,
                            can_delete: false,
                        };
                        permissions.push(permission);
                    }

                    if ($checkbox.is(':checked')) {
                        permission[`can_${action}`] = true;
                    }
                });

                // Submit via AJAX
                $.ajax({
                    url: formUrl,
                    type: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $form.find('input[name="_token"]').val()
                    },
                    data: JSON.stringify({ permissions: permissions }),
                    success: function(response) {
                        if (response.success) {
                            // Show success message with Toastr
                            if (typeof toastr !== 'undefined') {
                                swal.fire('Berhasil', response.message, 'success');
                            } else {
                                swal.fire('Berhasil', response.message, 'success');
                            }

                            // Reload after short delay
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            // Show error message
                            if (typeof toastr !== 'undefined') {
                                swal.fire('Gagal', response.message, 'error');
                            } else {
                                swal.fire('Gagal', response.message, 'error');
                            }

                            // Restore button state
                            $submitBtn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'Terjadi kesalahan saat menyimpan';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.statusText) {
                            errorMsg = xhr.statusText;
                        }

                        // Show error message
                        if (typeof toastr !== 'undefined') {
                            swal.fire('Gagal', errorMsg, 'error');
                        } else {
                            swal.fire('Gagal', errorMsg, 'error');
                        }

                        // Restore button state
                        $submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });

            $('#application_id').change(function() {
                 let application_id = $(this).val();
                 let url             = '{{ route('roles.index') }}?application_id=' + application_id;
                 let target          = $('#role_id');
                 let label           = 'Pilih Role';
                 ajaxGet(url, target, label);
             })
        });
    </script>
@endpush