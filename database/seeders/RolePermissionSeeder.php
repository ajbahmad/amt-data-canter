<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==================== ROLES ====================
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin System',
                'description' => 'Administrator dengan akses penuh ke semua fitur',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'operator',
                'display_name' => 'Operator Akademik',
                'description' => 'Operator yang mengelola data akademik',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'supervisor',
                'display_name' => 'Supervisor',
                'description' => 'Supervisor yang mengawasi operasional',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'teacher',
                'display_name' => 'Guru/Pendidik',
                'description' => 'Guru yang mengajar dan mengelola kelas',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'parent',
                'display_name' => 'Orang Tua',
                'description' => 'Orang tua siswa dengan akses terbatas',
                'order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // ==================== PERMISSIONS ====================
        $permissions = [
            // Dashboard
            ['name' => 'view-dashboard', 'display_name' => 'Lihat Dashboard', 'module' => 'dashboard', 'action' => 'view'],
            
            // School Institutions
            ['name' => 'view-school-institutions', 'display_name' => 'Lihat Institusi Sekolah', 'module' => 'school_institutions', 'action' => 'view'],
            ['name' => 'create-school-institutions', 'display_name' => 'Buat Institusi Sekolah', 'module' => 'school_institutions', 'action' => 'create'],
            ['name' => 'edit-school-institutions', 'display_name' => 'Edit Institusi Sekolah', 'module' => 'school_institutions', 'action' => 'edit'],
            ['name' => 'delete-school-institutions', 'display_name' => 'Hapus Institusi Sekolah', 'module' => 'school_institutions', 'action' => 'delete'],
            
            // School Levels
            ['name' => 'view-school-levels', 'display_name' => 'Lihat Level Sekolah', 'module' => 'school_levels', 'action' => 'view'],
            ['name' => 'create-school-levels', 'display_name' => 'Buat Level Sekolah', 'module' => 'school_levels', 'action' => 'create'],
            ['name' => 'edit-school-levels', 'display_name' => 'Edit Level Sekolah', 'module' => 'school_levels', 'action' => 'edit'],
            ['name' => 'delete-school-levels', 'display_name' => 'Hapus Level Sekolah', 'module' => 'school_levels', 'action' => 'delete'],
            
            // Grades
            ['name' => 'view-grades', 'display_name' => 'Lihat Tingkat Kelas', 'module' => 'grades', 'action' => 'view'],
            ['name' => 'create-grades', 'display_name' => 'Buat Tingkat Kelas', 'module' => 'grades', 'action' => 'create'],
            ['name' => 'edit-grades', 'display_name' => 'Edit Tingkat Kelas', 'module' => 'grades', 'action' => 'edit'],
            ['name' => 'delete-grades', 'display_name' => 'Hapus Tingkat Kelas', 'module' => 'grades', 'action' => 'delete'],
            
            // Subjects
            ['name' => 'view-subjects', 'display_name' => 'Lihat Mata Pelajaran', 'module' => 'subjects', 'action' => 'view'],
            ['name' => 'create-subjects', 'display_name' => 'Buat Mata Pelajaran', 'module' => 'subjects', 'action' => 'create'],
            ['name' => 'edit-subjects', 'display_name' => 'Edit Mata Pelajaran', 'module' => 'subjects', 'action' => 'edit'],
            ['name' => 'delete-subjects', 'display_name' => 'Hapus Mata Pelajaran', 'module' => 'subjects', 'action' => 'delete'],
            
            // School Years
            ['name' => 'view-school-years', 'display_name' => 'Lihat Tahun Ajaran', 'module' => 'school_years', 'action' => 'view'],
            ['name' => 'create-school-years', 'display_name' => 'Buat Tahun Ajaran', 'module' => 'school_years', 'action' => 'create'],
            ['name' => 'edit-school-years', 'display_name' => 'Edit Tahun Ajaran', 'module' => 'school_years', 'action' => 'edit'],
            ['name' => 'delete-school-years', 'display_name' => 'Hapus Tahun Ajaran', 'module' => 'school_years', 'action' => 'delete'],
            
            // Class Rooms
            ['name' => 'view-class-rooms', 'display_name' => 'Lihat Rombongan Belajar', 'module' => 'class_rooms', 'action' => 'view'],
            ['name' => 'create-class-rooms', 'display_name' => 'Buat Rombongan Belajar', 'module' => 'class_rooms', 'action' => 'create'],
            ['name' => 'edit-class-rooms', 'display_name' => 'Edit Rombongan Belajar', 'module' => 'class_rooms', 'action' => 'edit'],
            ['name' => 'delete-class-rooms', 'display_name' => 'Hapus Rombongan Belajar', 'module' => 'class_rooms', 'action' => 'delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // ==================== ASSIGN PERMISSIONS TO ROLES ====================
        // Admin has all permissions
        $admin = Role::where('name', 'admin')->first();
        $admin->permissions()->attach(Permission::all());

        // Operator has most permissions except admin-only
        $operator = Role::where('name', 'operator')->first();
        $operator->permissions()->attach(Permission::whereIn('name', [
            'view-dashboard',
            'view-school-institutions', 'create-school-institutions', 'edit-school-institutions', 'delete-school-institutions',
            'view-school-levels', 'create-school-levels', 'edit-school-levels', 'delete-school-levels',
            'view-grades', 'create-grades', 'edit-grades', 'delete-grades',
            'view-subjects', 'create-subjects', 'edit-subjects', 'delete-subjects',
            'view-school-years', 'create-school-years', 'edit-school-years', 'delete-school-years',
            'view-class-rooms', 'create-class-rooms', 'edit-class-rooms', 'delete-class-rooms',
        ])->get());

        // Supervisor can only view and edit
        $supervisor = Role::where('name', 'supervisor')->first();
        $supervisor->permissions()->attach(Permission::whereIn('name', [
            'view-dashboard',
            'view-school-institutions', 'edit-school-institutions',
            'view-school-levels', 'edit-school-levels',
            'view-grades', 'edit-grades',
            'view-subjects', 'edit-subjects',
            'view-school-years', 'edit-school-years',
            'view-class-rooms', 'edit-class-rooms',
        ])->get());

        // Teacher can only view
        $teacher = Role::where('name', 'teacher')->first();
        $teacher->permissions()->attach(Permission::whereIn('name', [
            'view-dashboard',
            'view-school-institutions',
            'view-school-levels',
            'view-grades',
            'view-subjects',
            'view-school-years',
            'view-class-rooms',
        ])->get());

        // Parent can only view dashboard
        $parent = Role::where('name', 'parent')->first();
        $parent->permissions()->attach(Permission::where('name', 'view-dashboard')->get());

        // ==================== MENUS ====================
        $menus = [
            // Main Menus
            [
                'name' => 'dashboard',
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fas fa-home',
                'description' => 'Halaman utama',
                'parent_id' => null,
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'master-data',
                'label' => 'Master Data',
                'route' => null,
                'icon' => 'fas fa-database',
                'description' => 'Kelola master data',
                'parent_id' => null,
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'academic',
                'label' => 'Akademik',
                'route' => null,
                'icon' => 'fas fa-book',
                'description' => 'Data akademik',
                'parent_id' => null,
                'order' => 3,
                'is_active' => true
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // Get parent menu IDs
        $masterDataMenu = Menu::where('name', 'master-data')->first();
        $academicMenu = Menu::where('name', 'academic')->first();

        // Sub Menus for Master Data
        $subMenus = [
            [
                'name' => 'school-institutions',
                'label' => 'Institusi Sekolah',
                'route' => 'school-institutions.index',
                'icon' => 'fas fa-school',
                'description' => 'Kelola institusi sekolah',
                'parent_id' => $masterDataMenu->id,
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'school-levels',
                'label' => 'Level Sekolah',
                'route' => 'school-levels.index',
                'icon' => 'fas fa-layer-group',
                'description' => 'Kelola level sekolah',
                'parent_id' => $masterDataMenu->id,
                'order' => 2,
                'is_active' => true
            ],
            // Sub Menus for Akademik
            [
                'name' => 'grades',
                'label' => 'Tingkat Kelas',
                'route' => 'grades.index',
                'icon' => 'fas fa-graduation-cap',
                'description' => 'Kelola tingkat kelas',
                'parent_id' => $academicMenu->id,
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'subjects',
                'label' => 'Mata Pelajaran',
                'route' => 'subjects.index',
                'icon' => 'fas fa-book-open',
                'description' => 'Kelola mata pelajaran',
                'parent_id' => $academicMenu->id,
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'school-years',
                'label' => 'Tahun Ajaran',
                'route' => 'school-years.index',
                'icon' => 'fas fa-calendar-alt',
                'description' => 'Kelola tahun ajaran',
                'parent_id' => $academicMenu->id,
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'class-rooms',
                'label' => 'Rombongan Belajar',
                'route' => 'class-rooms.index',
                'icon' => 'fas fa-chalkboard',
                'description' => 'Kelola rombongan belajar',
                'parent_id' => $academicMenu->id,
                'order' => 4,
                'is_active' => true
            ],
        ];

        foreach ($subMenus as $subMenu) {
            Menu::create($subMenu);
        }

        // ==================== ASSIGN MENUS TO ROLES ====================
        // Admin sees all menus
        $adminMenus = Menu::all();
        $admin->menus()->attach($adminMenus);

        // Operator sees all menus
        $operator->menus()->attach($adminMenus);

        // Supervisor sees dashboard dan academic menus
        $supervisorMenus = Menu::whereIn('name', ['dashboard', 'academic', 'grades', 'subjects', 'school-years', 'class-rooms'])->get();
        $supervisor->menus()->attach($supervisorMenus);

        // Teacher sees only dashboard
        $teacherMenus = Menu::where('name', 'dashboard')->get();
        $teacher->menus()->attach($teacherMenus);

        // Parent sees only dashboard
        $parent->menus()->attach($teacherMenus);
    }
}
