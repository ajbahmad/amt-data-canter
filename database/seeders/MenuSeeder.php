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

        // Define menu structure
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

            // MASTER DATA (Dropdown)
            [
                'type' => 'dropdown',
                'title' => 'Master Data',
                'icon' => 'ti ti-database',
                'color' => 'indigo',
                'menu_key' => 'master-data',
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
                        'title' => 'Tahun Ajaran',
                        'icon' => 'ti ti-calendar',
                        'color' => 'indigo',
                        'route' => 'school_years.index',
                        'order_no' => 2,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Semester',
                        'icon' => 'ti ti-clock',
                        'color' => 'indigo',
                        'route' => 'semesters.index',
                        'order_no' => 3,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tingkat Kelas',
                        'icon' => 'ti ti-list',
                        'color' => 'indigo',
                        'route' => 'grades.index',
                        'order_no' => 4,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Mata Pelajaran',
                        'icon' => 'ti ti-book',
                        'color' => 'indigo',
                        'route' => 'subjects.index',
                        'order_no' => 5,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Rombongan Belajar',
                        'icon' => 'ti ti-users',
                        'color' => 'indigo',
                        'route' => 'class_rooms.index',
                        'order_no' => 6,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Orang',
                        'icon' => 'ti ti-user',
                        'color' => 'indigo',
                        'route' => 'persons.index',
                        'order_no' => 7,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Tipe Orang',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'route' => 'person_types.index',
                        'order_no' => 8,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Siswa',
                        'icon' => 'ti ti-book',
                        'color' => 'indigo',
                        'route' => 'students.index',
                        'order_no' => 9,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Guru',
                        'icon' => 'ti ti-chalkboard',
                        'color' => 'indigo',
                        'route' => 'teachers.index',
                        'order_no' => 10,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Staf',
                        'icon' => 'ti ti-briefcase',
                        'color' => 'indigo',
                        'route' => 'staffs.index',
                        'order_no' => 11,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Jam Pelajaran',
                        'icon' => 'ti ti-clock',
                        'color' => 'indigo',
                        'route' => 'time_slots.index',
                        'order_no' => 12,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Penempatan Siswa',
                        'icon' => 'ti ti-users',
                        'color' => 'indigo',
                        'route' => 'class_room_students.index',
                        'order_no' => 13,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Wali Kelas',
                        'icon' => 'ti ti-users-group',
                        'color' => 'indigo',
                        'route' => 'class_room_homeroom_teachers.index',
                        'order_no' => 14,
                        'is_active' => true,
                    ],
                    [
                        'type' => 'item',
                        'title' => 'Penugasan Guru Mapel',
                        'icon' => 'ti ti-book',
                        'color' => 'indigo',
                        'route' => 'teacher_subject_assignments.index',
                        'order_no' => 15,
                        'is_active' => true,
                    ],
                ],
            ],

            // ACADEMIC (Dropdown)
            // [
            //     'type' => 'dropdown',
            //     'title' => 'Akademik',
            //     'icon' => 'ti ti-school',
            //     'color' => 'indigo',
            //     'menu_key' => 'academic',
            //     'order_no' => 20,
            //     'is_active' => true,
            //     'children' => [
            //         [
            //             'type' => 'item',
            //             'title' => 'Siswa',
            //             'icon' => 'ti ti-user',
            //             'color' => 'indigo',
            //             'route' => 'admin.students.index',
            //             'order_no' => 0,
            //             'is_active' => true,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Guru',
            //             'icon' => 'ti ti-user-check',
            //             'color' => 'indigo',
            //             'route' => 'admin.teachers.index',
            //             'order_no' => 1,
            //             'is_active' => true,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Jadwal Pelajaran',
            //             'icon' => 'ti ti-schedule',
            //             'color' => 'indigo',
            //             'route' => 'admin.class-schedules.index',
            //             'order_no' => 2,
            //             'is_active' => true,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Penugasan Guru',
            //             'icon' => 'ti ti-assignment',
            //             'color' => 'indigo',
            //             'route' => 'admin.teacher-subject-assignments.index',
            //             'order_no' => 3,
            //             'is_active' => true,
            //         ],
            //     ],
            // ],

            // // OPERASIONAL (Dropdown)
            // [
            //     'type' => 'dropdown',
            //     'title' => 'Operasional',
            //     'icon' => 'ti ti-tools',
            //     'color' => 'indigo',
            //     'menu_key' => 'operational',
            //     'order_no' => 30,
            //     'is_active' => true,
            //     'children' => [
            //         [
            //             'type' => 'item',
            //             'title' => 'Absensi',
            //             'icon' => 'ti ti-clipboard',
            //             'color' => 'indigo',
            //             'route' => 'admin.attendance.index',
            //             'order_no' => 0,
            //             'is_active' => true,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Kartu RFID',
            //             'icon' => 'ti ti-id',
            //             'color' => 'indigo',
            //             'route' => 'admin.id-cards.index',
            //             'order_no' => 1,
            //             'is_active' => true,
            //         ],
            //         [
            //             'type' => 'item',
            //             'title' => 'Jam Pelajaran',
            //             'icon' => 'ti ti-clock',
            //             'color' => 'indigo',
            //             'route' => 'admin.time-slots.index',
            //             'order_no' => 2,
            //             'is_active' => true,
            //         ],
            //     ],
            // ],

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
                'title' => 'Sistem',
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

        // Insert menus
        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);

            // Create parent menu
            $parentMenu = Menu::create($menuData);

            // Create children if any
            foreach ($children as $childData) {
                $childData['parent_id'] = $parentMenu->id;
                Menu::create($childData);
            }
        }

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

        $this->command->info('Menus dan permissions berhasil di-seed.');
    }
}

