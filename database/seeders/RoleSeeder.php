<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Role;
use App\Models\SchoolInstitution;
use App\Models\SchoolLevel;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Get applications
        $dataCenterApp = Application::where('slug', 'data-center')->first();
        $absensiApp = Application::where('slug', 'absensi')->first();
        $perpustakaanApp = Application::where('slug', 'perpustakaan')->first();
        $ppdbApp = Application::where('slug', 'ppdb')->first();
        $kantinApp = Application::where('slug', 'kantin')->first();

        // Get institutions
        $almujtama = SchoolInstitution::where('code', 'almujtama')->first();
        $bettet = SchoolInstitution::where('code', 'bettet')->first();
        $sumberGayam = SchoolInstitution::where('code', 'sumber-gayam')->first();

        // Get school levels for Almujtama
        $almujtamaSD = SchoolLevel::where('school_institution_id', $almujtama?->id)
            ->where('code', 'sd')->first();
        $almujtamaSMP = SchoolLevel::where('school_institution_id', $almujtama?->id)
            ->where('code', 'smp')->first();
        $almujtamaSMA = SchoolLevel::where('school_institution_id', $almujtama?->id)
            ->where('code', 'sma')->first();

        // ============================================================
        // DATA-CENTER APP ROLES
        // ============================================================
        if ($dataCenterApp) {
            Role::firstOrCreate(
                ['application_id' => $dataCenterApp->id, 'slug' => 'admin'],
                [
                    'name' => 'Administrator Sistem',
                    'slug' => 'administrator-sistem',
                    'description' => 'Superuser dengan akses ke semua fitur sistem',
                    'scope' => 'global',
                    'priority' => 100,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }

        // ============================================================
        // ABSENSI APP ROLES
        // ============================================================

        if ($absensiApp) {
            // Global Admin
            Role::firstOrCreate(
                ['application_id' => $absensiApp->id, 'slug' => 'admin'],
                [
                    'name' => 'Administrator Sistem',
                    'description' => 'Superuser dengan akses ke semua fitur sistem',
                    'scope' => 'global',
                    'priority' => 100,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            // Institution Admin
            if ($almujtama) {
                Role::firstOrCreate(
                    ['application_id' => $absensiApp->id, 'slug' => 'institution-admin-almujtama'],
                    [
                        'name' => 'Admin Institusi Almujtama',
                        'description' => 'Administrator institusi Almujtama',
                        'scope' => 'institution',
                        'school_institution_id' => $almujtama->id,
                        'priority' => 80,
                        'is_system' => true,
                        'is_active' => true,
                    ]
                );
            }

            // School Level Admin
            if ($almujtamaSD) {
                Role::firstOrCreate(
                    ['application_id' => $absensiApp->id, 'slug' => 'school-admin-almujtama-sd'],
                    [
                        'name' => 'Admin Sekolah SD Almujtama',
                        'description' => 'Administrator tingkat sekolah SD',
                        'scope' => 'school',
                        'school_institution_id' => $almujtama->id,
                        'school_level_id' => $almujtamaSD->id,
                        'priority' => 60,
                        'is_system' => true,
                        'is_active' => true,
                    ]
                );
            }

            // Teacher Role
            Role::firstOrCreate(
                ['application_id' => $absensiApp->id, 'slug' => 'guru'],
                [
                    'name' => 'Guru',
                    'description' => 'Guru yang dapat mengelola kehadiran kelas',
                    'scope' => 'global',
                    'priority' => 40,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            // Student Role
            Role::firstOrCreate(
                ['application_id' => $absensiApp->id, 'slug' => 'siswa'],
                [
                    'name' => 'Siswa',
                    'description' => 'Siswa yang dapat melihat kehadiran mereka',
                    'scope' => 'global',
                    'priority' => 20,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }

        // ============================================================
        // PERPUSTAKAAN APP ROLES
        // ============================================================

        if ($perpustakaanApp) {
            Role::firstOrCreate(
                ['application_id' => $perpustakaanApp->id, 'slug' => 'admin'],
                [
                    'name' => 'Administrator Sistem',
                    'description' => 'Superuser dengan akses ke semua fitur perpustakaan',
                    'scope' => 'global',
                    'priority' => 100,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            Role::firstOrCreate(
                ['application_id' => $perpustakaanApp->id, 'slug' => 'librarian'],
                [
                    'name' => 'Pustakawan',
                    'description' => 'Pengelola perpustakaan',
                    'scope' => 'global',
                    'priority' => 80,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            Role::firstOrCreate(
                ['application_id' => $perpustakaanApp->id, 'slug' => 'member'],
                [
                    'name' => 'Anggota',
                    'description' => 'Anggota yang dapat meminjam buku',
                    'scope' => 'global',
                    'priority' => 30,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }

        // ============================================================
        // PPDB APP ROLES
        // ============================================================

        if ($ppdbApp) {
            Role::firstOrCreate(
                ['application_id' => $ppdbApp->id, 'slug' => 'admin'],
                [
                    'name' => 'Administrator Sistem',
                    'description' => 'Superuser PPDB',
                    'scope' => 'global',
                    'priority' => 100,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            if ($almujtama) {
                Role::firstOrCreate(
                    ['application_id' => $ppdbApp->id, 'slug' => 'panitia-ppdb-almujtama'],
                    [
                        'name' => 'Panitia PPDB Almujtama',
                        'description' => 'Panitia penerimaan siswa baru',
                        'scope' => 'institution',
                        'school_institution_id' => $almujtama->id,
                        'priority' => 70,
                        'is_system' => true,
                        'is_active' => true,
                    ]
                );
            }

            Role::firstOrCreate(
                ['application_id' => $ppdbApp->id, 'slug' => 'calon-siswa'],
                [
                    'name' => 'Calon Siswa',
                    'description' => 'Calon siswa yang mendaftar',
                    'scope' => 'global',
                    'priority' => 20,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }

        // ============================================================
        // KANTIN APP ROLES
        // ============================================================

        if ($kantinApp) {
            Role::firstOrCreate(
                ['application_id' => $kantinApp->id, 'slug' => 'admin'],
                [
                    'name' => 'Administrator Sistem',
                    'description' => 'Superuser kantin',
                    'scope' => 'global',
                    'priority' => 100,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            Role::firstOrCreate(
                ['application_id' => $kantinApp->id, 'slug' => 'kasir'],
                [
                    'name' => 'Kasir',
                    'description' => 'Kasir kantin',
                    'scope' => 'global',
                    'priority' => 70,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );

            Role::firstOrCreate(
                ['application_id' => $kantinApp->id, 'slug' => 'pembeli'],
                [
                    'name' => 'Pembeli',
                    'description' => 'Pelanggan kantin',
                    'scope' => 'global',
                    'priority' => 20,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }


        $roleId = Role::first();
        $userId = User::first();
        UserRole::create([
            'user_id'   => $userId->id,
            'role_id'   => $roleId->id
        ]);
    }
}
