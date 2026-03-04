<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@smk.amt',
        ], [
            'id' => (string) Str::uuid(),
            'name' => 'Admin',
            'password' => bcrypt('password'),
            // 'role_id' => 1,
        ]);
    }
}
