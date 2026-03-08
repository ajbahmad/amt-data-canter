<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuPermission;
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

        // Define menu structure with support for unlimited nesting levels
        $menus = [
            // Dashboard
            [
                'type' => 'item',
                'title' => 'Dashboard',
                'icon' => 'ti ti-dashboard',
                'color' => 'indigo',
                'route' => 'dashboard',
                'order_no' => 0,
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
                        'title' => 'Institusi Sekolah',
                        'icon' => 'ti ti-building',
                        'color' => 'indigo',
                        'route' => 'school_institutions.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Level Sekolah',
                        'icon' => 'ti ti-box',
                        'color' => 'indigo',
                        'route' => 'school_levels.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tingkat Kelas',
                        'icon' => 'ti ti-list',
                        'color' => 'indigo',
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
                                'route' => 'school_years.index',
                                'order_no' => 0,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Semester',
                                'icon' => 'ti ti-clock',
                                'color' => 'indigo',
                                'route' => 'semesters.index',
                                'order_no' => 1,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Mata Pelajaran',
                                'icon' => 'ti ti-book',
                                'color' => 'indigo',
                                'route' => 'subjects.index',
                                'order_no' => 2,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Jam Pelajaran',
                                'icon' => 'ti ti-clock',
                                'color' => 'indigo',
                                'route' => 'time_slots.index',
                                'order_no' => 3,
                                'is_active' => true,
                            ],
                            [
                                'type' => 'item',
                                'title' => 'Pola Jadwal',
                                'icon' => 'ti ti-calendar-event',
                                'color' => 'indigo',
                                'route' => 'schedule-patterns.index',
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
                        'route' => 'class_rooms.index',
                        'order_no' => 4,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Guru Mapel',
                        'icon' => 'ti ti-book-2',
                        'color' => 'indigo',
                        'route' => 'teacher_subject_assignments.index',
                        'order_no' => 5,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Wali Kelas',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'route' => 'class_room_homeroom_teachers.index',
                        'order_no' => 6,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Jadwal Kelas',
                        'icon' => 'ti ti-file-text',
                        'color' => 'indigo',
                        'route' => 'class_schedules.index',
                        'order_no' => 7,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Jadwal Harian',
                        'icon' => 'ti ti-calendar-time',
                        'color' => 'indigo',
                        'route' => 'school-day-schedules.index',
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
                        'route' => 'persons.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tipe Pengguna',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'route' => 'person_types.index',
                        'order_no' => 1,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Guru',
                        'icon' => 'ti ti-chalkboard',
                        'color' => 'indigo',
                        'route' => 'teachers.index',
                        'order_no' => 2,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Staf',
                        'icon' => 'ti ti-briefcase',
                        'color' => 'indigo',
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
                        'route' => 'students.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Penempatan Siswa',
                        'icon' => 'ti ti-book-2',
                        'color' => 'indigo',
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
                'order_no' => 50,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Kartu ID',
                        'icon' => 'ti ti-id',
                        'color' => 'indigo',
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
            //             'color' => 'indigo',
            //             'route' => 'admin.reports.students',
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

            // SISTEM (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'SISTEM',
                'icon' => 'ti ti-settings',
                'color' => 'indigo',
                'menu_key' => 'system',
                'order_no' => 50,
                'is_active' => true,
                'children' => [
                    [
                        'type' => 'item',
                        'title' => 'Menu Sidebar',
                        'icon' => 'ti ti-menu',
                        'color' => 'indigo',
                        'route' => 'admin.menus.index',
                        'order_no' => 0,
                        'is_active' => true,
                    ],
                    // [
                    //     'type' => 'item',
                    //     'title' => 'User & Role',
                    //     'icon' => 'ti ti-lock',
                    //     'color' => 'indigo',
                    //     'route' => 'admin.users.index',
                    //     'order_no' => 1,
                    //     'is_active' => true,
                    // ],
                    // [
                    //     'type' => 'item',
                    //     'title' => 'Audit Log',
                    //     'icon' => 'ti ti-history',
                    //     'color' => 'indigo',
                    //     'route' => 'admin.audit-logs.index',
                    //     'order_no' => 2,
                    //     'is_active' => true,
                    // ],
                    // [
                    //     'type' => 'item',
                    //     'title' => 'Pengaturan',
                    //     'icon' => 'ti ti-settings-2',
                    //     'color' => 'indigo',
                    //     'route' => 'admin.settings.index',
                    //     'order_no' => 3,
                    //     'is_active' => true,
                    // ],
                ],
            ],
        ];

        Menu::truncate(); // Clear existing data

        // Insert menus recursively
        $this->insertMenusRecursively($menus);

        // Create permissions for all menus
        $menus = Menu::all();
        $roles = ['super-admin', 'admin', 'teacher', 'student', 'parent', 'staff'];

        foreach ($menus as $menu) {
            // Super admin dapat akses semua dengan full permission
            MenuPermission::create([
                'menu_id' => $menu->id,
                'role_code' => 'super-admin',
                'can_view' => true,
                'can_create' => true,
                'can_edit' => true,
                'can_delete' => true,
            ]);

            // Admin can view semua, edit master data
            if ($menu->type === 'item' && strpos($menu->route ?? '', 'master-data') === false) {
                MenuPermission::create([
                    'menu_id' => $menu->id,
                    'role_code' => 'admin',
                    'can_view' => true,
                    'can_create' => false,
                    'can_edit' => false,
                    'can_delete' => false,
                ]);
            }

            // Teacher dapat akses dashboard dan academic
            if (in_array($menu->menu_key, ['academic']) || $menu->title === 'Dashboard') {
                MenuPermission::create([
                    'menu_id' => $menu->id,
                    'role_code' => 'teacher',
                    'can_view' => true,
                    'can_create' => false,
                    'can_edit' => false,
                    'can_delete' => false,
                ]);
            }

            // Student dapat akses dashboard
            if ($menu->title === 'Dashboard') {
                MenuPermission::create([
                    'menu_id' => $menu->id,
                    'role_code' => 'student',
                    'can_view' => true,
                    'can_create' => false,
                    'can_edit' => false,
                    'can_delete' => false,
                ]);
            }
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

            // Create the menu
            $menu = Menu::create($menuData);

            // Recursively create children menus
            if (!empty($children)) {
                $this->insertMenusRecursively($children, $menu);
            }
        }
    }
}
