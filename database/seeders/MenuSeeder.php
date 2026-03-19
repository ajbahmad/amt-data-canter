<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::query()->delete();

        $idAbsensi = Application::where('slug', 'absensi')->first()?->id;
        $idDataCenter = Application::where('slug', 'data-center')->first()?->id;
        // Define menu structure with support for unlimited nesting levels
        $menus = [
            // Dashboard
            [
                'type' => 'item',
                'title' => 'Dashboard',
                'icon' => 'ti ti-dashboard',
                'color' => 'indigo',
                'resource' => 'dashboard',
                'route' => 'dashboard',
                'order_no' => 0,
                'is_active' => true,
            ],

            // Calendars
            [
                'type' => 'item',
                'title' => 'Kalender Akademik',
                'icon' => 'ti ti-calendar-event',
                'color' => 'indigo',
                'resource' => 'calendars',
                'route' => 'calendars.grid',
                'order_no' => 5,
                'is_active' => true,
            ],
            [
                'type' => 'label',
                'title' => 'MASTER DATA',
                'icon' => '',
                'color' => 'indigo',
                'order_no' => 5,
                'is_active' => true,
            ],

            // ORGANISASI (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'ORGANISASI',
                'icon' => 'ti ti-building-community',
                'color' => 'indigo',
                'menu_key' => 'organisasi',
                'order_no' => 10,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Lembaga',
                        'icon' => 'ti ti-building',
                        'color' => 'indigo',
                        'resource' => 'school_institutions',
                        'route' => 'school_institutions.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Sekolah',
                        'icon' => 'ti ti-box',
                        'color' => 'indigo',
                        'resource' => 'school_levels',
                        'route' => 'school_levels.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tingkat Kelas',
                        'icon' => 'ti ti-list',
                        'color' => 'indigo',
                        'resource' => 'grades',
                        'route' => 'grades.index',
                        'order_no' => 2,
                        'is_active' => true,
                    ],
                ],
            ],

            // AKADEMIK (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'AKADEMIK',
                'icon' => 'ti ti-school',
                'color' => 'indigo',
                'menu_key' => 'akademik',
                'order_no' => 20,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'dropdown',
                        'title' => 'Master Akademik',
                        'icon' => 'ti ti-settings',
                        'color' => 'indigo',
                        'menu_key' => 'master_akademik',
                        'order_no' => 20,
                        'is_active' => true,
                        'children'  => [
                            [
                                'type' => 'item',
                                'title' => 'Tahun Ajaran',
                                'icon' => 'ti ti-calendar',
                                'color' => 'indigo',
                                'resource' => 'school_years',
                                'route' => 'school_years.index',
                                'order_no' => 0,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Semester',
                                'icon' => 'ti ti-clock',
                                'color' => 'indigo',
                                'resource' => 'semesters',
                                'route' => 'semesters.index',
                                'order_no' => 1,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Mata Pelajaran',
                                'icon' => 'ti ti-book',
                                'color' => 'indigo',
                                'resource' => 'subjects',
                                'route' => 'subjects.index',
                                'order_no' => 2,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Jam Pelajaran',
                                'icon' => 'ti ti-clock',
                                'color' => 'indigo',
                                'resource' => 'time_slots',
                                'route' => 'time_slots.index',
                                'order_no' => 3,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Pola Jadwal',
                                'icon' => 'ti ti-calendar-event',
                                'color' => 'indigo',
                                'resource' => 'schedule_patterns',
                                'route' => 'schedule_patterns.index',
                                'order_no' => 8,
                                'is_active' => true,
                            ],
                        ]
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Rombel & Jadwal',
                        'icon' => 'ti ti-users',
                        'color' => 'indigo',
                        'resource' => 'class_rooms',
                        'route' => 'class_rooms.index',
                        'order_no' => 4,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'is_global' => false,
                        'application_id' => $idDataCenter,
                        'is_sidebar_menu' => false,
                        'title' => 'Set Schedule',
                        'icon' => 'ti ti-clock',
                        'color' => 'indigo',
                        'resource' => 'class_rooms',
                        'route' => 'class_rooms.set_schedule',
                        'order_no' => 4,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Guru Mapel',
                        'icon' => 'ti ti-book-2',
                        'color' => 'indigo',
                        'resource' => 'teacher_subject_assignments',
                        'route' => 'teacher_subject_assignments.index',
                        'order_no' => 5,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Wali Kelas',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'resource' => 'class_room_homeroom_teachers',
                        'route' => 'class_room_homeroom_teachers.index',
                        'order_no' => 6,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Jadwal Kelas',
                        'icon' => 'ti ti-file-text',
                        'color' => 'indigo',
                        'resource' => 'class_schedules',
                        'route' => 'class_schedules.index',
                        'order_no' => 7,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Jadwal Harian',
                        'icon' => 'ti ti-calendar-time',
                        'color' => 'indigo',
                        'resource' => 'school_day_schedules',
                        'route' => 'school_day_schedules.index',
                        'order_no' => 9,
                        'is_active' => true,
                    ],
                ],
            ],

            // SUMBER DAYA MANUSIA (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'SDM',
                'icon' => 'ti ti-users',
                'color' => 'indigo',
                'menu_key' => 'sdm',
                'order_no' => 30,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Pengguna',
                        'icon' => 'ti ti-user',
                        'color' => 'indigo',
                        'resource' => 'persons',
                        'route' => 'persons.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tipe Pengguna',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'resource' => 'person_types',
                        'route' => 'person_types.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Guru',
                        'icon' => 'ti ti-chalkboard',
                        'color' => 'indigo',
                        'resource' => 'teachers',
                        'route' => 'teachers.index',
                        'order_no' => 2,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Staf',
                        'icon' => 'ti ti-briefcase',
                        'color' => 'indigo',
                        'resource' => 'staffs',
                        'route' => 'staffs.index',
                        'order_no' => 3,
                        'is_active' => true,
                    ],
                ],
            ],

            // PESERTA DIDIK (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'PESERTA DIDIK',
                'icon' => 'ti ti-users-group',
                'color' => 'indigo',
                'menu_key' => 'peserta-didik',
                'order_no' => 40,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Siswa',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'resource' => 'students',
                        'route' => 'students.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Penempatan Siswa',
                        'icon' => 'ti ti-book-2',
                        'color' => 'indigo',
                        'resource' => 'class_room_students',
                        'route' => 'class_room_students.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                ],
            ],

            // IDENTITAS (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'IDENTITAS',
                'icon' => 'ti ti-id',
                'color' => 'indigo',
                'menu_key' => 'identitas',
                'order_no' => 41,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Kartu ID',
                        'icon' => 'ti ti-id',
                        'color' => 'indigo',
                        'resource' => 'id_cards',
                        'route' => 'id_cards.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                ],
            ],

            // LAPORAN (Dropdown)
            // [
            //     'type' => 'dropdown',
            //     'title' => 'Laporan',
            //     'icon' => 'ti ti-report',
            //     'color' => 'indigo',
            //     'menu_key' => 'reporting',
            //     'order_no' => 40,
            //     'is_active' => true,
            //     'badge' => 'Coming',
            //     'badge_color' => 'yellow',
            //     'children' => [
            //         [
            //             'type' => 'item',
            //             'title' => 'Laporan Siswa',
            //             'icon' => 'ti ti-file-text',
            //             'color' => 'indigoresource
            //             'route' 'admin.reports.students',//             
            //             'order_no' => 0,
            //             'is_active' => false,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Laporan Absensi',
            //             'icon' => 'ti ti-file-text',
            //             'color' => 'indigo',
            //             'route' => 'admin.reports.attendance',
            //             'order_no' => 1,
            //             'is_active' => false,
            //         ],
            //     ],
            // ],
            // SISTEM & KEAMANAN (Dropdown - IAM)
            [
                'type' => 'dropdown',
                'title' => 'SISTEM & KEAMANAN',
                'icon' => 'ti ti-shield-check',
                'color' => 'indigo',
                'menu_key' => 'security-access',
                'order_no' => 43,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Applications',
                        'icon' => 'ti ti-app-window',
                        'color' => 'indigo',
                        'resource' => 'applications',
                        'route' => 'applications.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Menu & Permissions',
                        'icon' => 'ti ti-menu',
                        'color' => 'indigo',
                        'resource' => 'menus',
                        'route' => 'menus.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Roles',
                        'icon' => 'ti ti-badge',
                        'color' => 'indigo',
                        'resource' => 'roles',
                        'route' => 'roles.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Users',
                        'icon' => 'ti ti-users',
                        'color' => 'indigo',
                        'resource' => 'users',
                        'route' => 'users.index',
                        'order_no' => 2,
                        'is_active' => true,
                    ],
                ],
            ],

            [
                'type' => 'item',
                'title' => 'Kalender Akademik',
                'icon' => 'ti ti-calendar-event',
                'color' => 'indigo',
                'resource' => 'calendars',
                'route' => 'calendars.grid',
                'is_global' => false,
                'application_id' => $idAbsensi,
                'order_no' => 5,
                'is_active' => true,
            ],
            [
                'type' => 'item',
                'title' => 'Absensi',
                'icon' => 'ti ti-calendar-event',
                'color' => 'indigo',
                'resource' => 'calendars',
                'route' => 'calendars.grid',
                'is_global' => false,
                'application_id' => $idAbsensi,
                'order_no' => 5,
                'is_active' => true,
            ],
        ];

        Menu::truncate(); // Clear existing data

        // Insert menus recursively
        $this->insertMenusRecursively($menus);

        // Create permissions for all menus
        $menus = Menu::all();
        $roleId = Role::get()->first();

        foreach ($menus as $menu) {
            // Super admin dapat akses semua dengan full permission
            MenuPermission::create([
                'menu_id' => $menu->id,
                'role_id' => $roleId->id,
                'role_code' => $roleId->slug,
                'can_view' => true,
                'can_create' => true,
                'can_edit' => true,
                'can_delete' => true,
            ]);

            //     // Admin can view semua, edit master data
            //     if ($menu->type === 'item' && strpos($menu->route ?? '', 'master-data') === false) {
            //         MenuPermission::create([
            //             'menu_id' => $menu->id,
            //             'role_id' => $roleId,
            //             'role_code' => 'admin',
            //             'can_view' => true,
            //             'can_create' => false,
            //             'can_edit' => false,
            //             'can_delete' => false,
            //         ]);
            //     }

            //     // Teacher dapat akses dashboard dan academic
            //     if (in_array($menu->menu_key, ['academic']) || $menu->title === 'Dashboard') {
            //         MenuPermission::create([
            //             'menu_id' => $menu->id,
            //             'role_id' => $roleId,
            //             'role_code' => 'teacher',
            //             'can_view' => true,
            //             'can_create' => false,
            //             'can_edit' => false,
            //             'can_delete' => false,
            //         ]);
            //     }

            //     // Student dapat akses dashboard
            //     if ($menu->title === 'Dashboard') {
            //         MenuPermission::create([
            //             'menu_id' => $menu->id,
            //             'role_id' => $roleId,
            //             'role_code' => 'student',
            //             'can_view' => true,
            //             'can_create' => false,
            //             'can_edit' => false,
            //             'can_delete' => false,
            //         ]);
            //     }
            // }
        }
    }

    /**
     * Insert menus recursively to support unlimited nesting levels
     * 
     * @param array $menus Array of menu items to insert
     * @param Menu|null $parentMenu Parent menu object (null for root level)
     */
    private function insertMenusRecursively(array $menus, ?Menu $parentMenu = null): void
    {
        foreach ($menus as $menuData) {
            // Extract children before creating the menu
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);

            // Set parent_id if this is a child menu
            if ($parentMenu !== null) {
                $menuData['parent_id'] = $parentMenu->id;
            }

            // Set default is_sidebar_menu to true if not provided
            if (!isset($menuData['is_sidebar_menu'])) {
                $menuData['is_sidebar_menu'] = true;
            }

            // Set default is_global to true if not provided (global menu by default)
            if (!isset($menuData['is_global'])) {
                $menuData['is_global'] = true;
            }

            // Create the menu
            $menu = Menu::create($menuData);

            // Recursively create children menus
            if (!empty($children)) {
                $this->insertMenusRecursively($children, $menu);
            }
        }
    }
}
