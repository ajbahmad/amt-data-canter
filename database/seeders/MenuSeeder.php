<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            /**
             * ============================================================
             * MENU ROOT: DROPDOWN (Manajemen Studi)
             * ============================================================
             */
            $dropdownId = DB::table('menus')->insertGetId([
                'parent_id' => null,
                'type' => 'dropdown',
                'title' => 'Manajemen Studi',
                'icon' => 'solar:book-bookmark-line-duotone',
                'color' => 'info',
                'menu_key' => 'studies-accordion', // untuk id accordion
                'route' => null,
                'url' => null,
                'order_no' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /**
             * ============================================================
             * CHILD 1: Bidang Studi
             * ============================================================
             */
            $child1Id = DB::table('menus')->insertGetId([
                'parent_id' => $dropdownId,
                'type' => 'item',
                'title' => 'Bidang Studi',
                'icon' => null,
                'color' => null,
                'menu_key' => null,
                'route' => 'admin.studies.index',
                'url' => null,
                'order_no' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /**
             * ============================================================
             * CHILD 2: Kategori Kelas
             * ============================================================
             */
            $child2Id = DB::table('menus')->insertGetId([
                'parent_id' => $dropdownId,
                'type' => 'item',
                'title' => 'Kategori Kelas',
                'icon' => null,
                'color' => null,
                'menu_key' => null,
                'route' => 'admin.class-categories.index',
                'url' => null,
                'order_no' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            /**
             * ============================================================
             * PERMISSIONS (admin, teacher)
             * ============================================================
             *
             * Karena permission di contoh kamu berlaku untuk child menu,
             * maka kita set permission di masing-masing child.
             *
             * Note:
             * Bisa juga set permission di dropdown parent kalau mau dropdown
             * hanya muncul untuk role tertentu.
             */
            $roles = ['admin', 'teacher'];

            foreach ($roles as $role) {
                DB::table('menu_permissions')->insert([
                    [
                        'menu_id' => $child1Id,
                        'role_code' => $role,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'menu_id' => $child2Id,
                        'role_code' => $role,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }

            /**
             * OPTIONAL:
             * Jika dropdown juga perlu permission, aktifkan ini:
             */
            foreach ($roles as $role) {
                DB::table('menu_permissions')->updateOrInsert(
                    [
                        'menu_id' => $dropdownId,
                        'role_code' => $role,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        });
    }
}
