<?php

namespace Database\Seeders;

use App\Models\SchoolInstitution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolInstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolInstitution::updateOrCreate([
            'code' => 'AMT',
        ], [
            'id' => Str::uuid(),
            'name' => 'ALMUJTAMA\'',
            'npsn' => '28138291083',
            'address' => 'Jl. Raya Pegantenan Km. 09, Pegantenan, Pamekasan 69361, Tengracak, Plakpak, Kec. Pegantenan, Kabupaten Pamekasan, Jawa Timur 69361',
            'phone' => '085130368951',
            'email' => 'ahmadjanuarbudiono@gmail.com',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
