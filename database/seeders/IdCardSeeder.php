<?php

namespace Database\Seeders;

use App\Models\IdCard;
use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IdCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua persons yang aktif
        $persons = Person::where('is_active', true)->get();

        if ($persons->isEmpty()) {
            $this->command->warn('Tidak ada person yang aktif. Lewatkan IdCardSeeder.');
            return;
        }

        // Buat kartu ID untuk sebagian persons (70% dari total)
        $personCount = $persons->count();
        $cardsToCreate = (int) ($personCount * 0.7);

        foreach ($persons->take($cardsToCreate) as $person) {
            IdCard::create([
                'id' => Str::uuid(),
                'card_uid' => 'UID-' . strtoupper(Str::random(12)),
                'card_number' => 'CARD-' . str_pad($person->id, 6, '0', STR_PAD_LEFT),
                'person_id' => $person->id,
                'status' => fake()->randomElement(['active', 'active', 'active', 'lost', 'blocked', 'expired']),
                'issued_at' => fake()->dateTimeBetween('-2 years'),
                'expired_at' => fake()->optional(0.7)->dateTimeBetween('now', '+5 years'),
            ]);
        }

        $this->command->info('IdCard Seeder selesai');
    }
}
