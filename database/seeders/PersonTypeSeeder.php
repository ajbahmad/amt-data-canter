<?php

namespace Database\Seeders;

use App\Models\PersonType;
use App\Models\SchoolInstitution;
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
        ];

        foreach (SchoolInstitution::all() as $key => $value) {
            # code...
            foreach ($personTypes as $personType) {
                PersonType::firstOrCreate(
                    [
                        'name' => $personType['name'],
                        'school_institution_id' => $value->id
                    ],
                    $personType
                );
            }
        }
    }
}
