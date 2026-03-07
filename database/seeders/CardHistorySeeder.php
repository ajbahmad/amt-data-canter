<?php

namespace Database\Seeders;

use App\Models\IdCard;
use App\Models\CardHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kartu ID yang sudah dibuat
        $idCards = IdCard::with('person')->get();

        if ($idCards->isEmpty()) {
            $this->command->warn('Tidak ada IdCard. Lewatkan CardHistorySeeder.');
            return;
        }

        $actions = ['issued', 'blocked', 'lost', 'replaced', 'unblocked', 'expired'];
        $actionNotes = [
            'issued' => 'Kartu ID dikeluarkan',
            'blocked' => 'Kartu diblokir karena keamanan',
            'lost' => 'Kartu hilang dilaporkan oleh pemilik',
            'replaced' => 'Kartu rusak, diganti dengan yang baru',
            'unblocked' => 'Kartu diaktifkan kembali',
            'expired' => 'Kartu sudah kadaluarsa',
        ];

        foreach ($idCards as $idCard) {
            // Initial issue record
            CardHistory::create([
                'id' => Str::uuid(),
                'id_card_id' => $idCard->id,
                'person_id' => $idCard->person_id,
                'action' => 'issued',
                'notes' => $actionNotes['issued'],
                'created_at' => $idCard->created_at,
                'updated_at' => $idCard->created_at,
            ]);

            // Additional history records (0-3 per kartu)
            $historyCount = fake()->numberBetween(0, 3);
            for ($i = 0; $i < $historyCount; $i++) {
                $action = fake()->randomElement($actions);
                
                CardHistory::create([
                    'id' => Str::uuid(),
                    'id_card_id' => $idCard->id,
                    'person_id' => $idCard->person_id,
                    'action' => $action,
                    'notes' => $actionNotes[$action] ?? fake()->optional()->sentence(),
                    'created_at' => fake()->dateTimeBetween($idCard->created_at, 'now'),
                    'updated_at' => fake()->dateTimeBetween($idCard->created_at, 'now'),
                ]);
            }
        }

        $this->command->info('CardHistory Seeder selesai');
    }
}
