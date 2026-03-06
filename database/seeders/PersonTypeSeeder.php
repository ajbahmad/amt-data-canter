<?php

namespace Database\Seeders;

use App\Models\PersonType;
use Illuminate\Database\Seeder;

class PersonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personTypes = [
            [
                'name' => 'Siswa',
                'description' => 'Tipe orang yang merupakan peserta didik di sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Guru',
                'description' => 'Tipe orang yang merupakan pendidik di sekolah',
                'is_active' => true,
            ],
            [
                'name' => 'Staf',
                'description' => 'Tipe orang yang merupakan staff administratif atau non-akademik',
                'is_active' => true,
            ],
            [
                'name' => 'Orang Tua',
                'description' => 'Tipe orang yang merupakan orang tua/wali dari siswa',
                'is_active' => true,
            ],
            [
                'name' => 'Alumni',
                'description' => 'Tipe orang yang merupakan alumni dari sekolah',
                'is_active' => true,
            ],
        ];

        foreach ($personTypes as $personType) {
            PersonType::firstOrCreate(
                ['name' => $personType['name']],
                $personType
            );
        }
    }
}
