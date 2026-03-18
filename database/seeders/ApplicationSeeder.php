<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $applications = [
            [
                'name' => 'Data Center',
                'slug' => 'data-center',
                'description' => 'Sistem manajemen data dan informasi',
                'logo_url' => 'https://via.placeholder.com/150?text=Data+Center',
                'website_url' => 'https://data-center.example.com',
                'api_base_url' => 'https://api.data-center.example.com',
                'api_client_id' => 'client_data_center_' . Str::random(10),
                'is_active' => true,
            ],
            [
                'name' => 'Sistem Absensi',
                'slug' => 'absensi',
                'description' => 'Sistem manajemen kehadiran siswa dan guru',
                'logo_url' => 'https://via.placeholder.com/150?text=Absensi',
                'website_url' => 'https://absensi.example.com',
                'api_base_url' => 'https://api.absensi.example.com',
                'api_client_id' => 'client_absensi_' . Str::random(10),
                'is_active' => true,
            ],
            [
                'name' => 'Sistem Perpustakaan',
                'slug' => 'perpustakaan',
                'description' => 'Sistem manajemen koleksi buku dan peminjaman',
                'logo_url' => 'https://via.placeholder.com/150?text=Perpustakaan',
                'website_url' => 'https://perpustakaan.example.com',
                'api_base_url' => 'https://api.perpustakaan.example.com',
                'api_client_id' => 'client_perpustakaan_' . Str::random(10),
                'is_active' => true,
            ],
            [
                'name' => 'Sistem PPDB',
                'slug' => 'ppdb',
                'description' => 'Sistem Penerimaan Peserta Didik Baru',
                'logo_url' => 'https://via.placeholder.com/150?text=PPDB',
                'website_url' => 'https://ppdb.example.com',
                'api_base_url' => 'https://api.ppdb.example.com',
                'api_client_id' => 'client_ppdb_' . Str::random(10),
                'is_active' => true,
            ],
            [
                'name' => 'Sistem Kantin',
                'slug' => 'kantin',
                'description' => 'Sistem manajemen penjualan dan inventori kantin',
                'logo_url' => 'https://via.placeholder.com/150?text=Kantin',
                'website_url' => 'https://kantin.example.com',
                'api_base_url' => 'https://api.kantin.example.com',
                'api_client_id' => 'client_kantin_' . Str::random(10),
                'is_active' => true,
            ],
        ];

        foreach ($applications as $app) {
            Application::firstOrCreate(
                ['slug' => $app['slug']],
                $app
            );
        }
    }
}
