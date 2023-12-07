<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private static array $playersMock = [
        [
            'name' => 'André',
            'path_image' => 'https://www.wribeiiro.com/players/andre.png',
        ],
        [
            'name' => 'Benjamim',
            'path_image' => 'https://www.wribeiiro.com/players/benja.png',
        ],
        [
            'name' => 'Cassiano',
            'path_image' => 'https://www.wribeiiro.com/players/cassiano.png',
        ],
        [
            'name' => 'Cleferson',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Daniel',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'De Gea',
            'path_image' => 'https://www.wribeiiro.com/players/degea.png',
        ],
        [
            'name' => 'Fábio',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Júlio',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Léo',
            'path_image' => 'https://www.wribeiiro.com/players/leo.png',
        ],
        [
            'name' => 'Gean Felipe',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Luciano',
            'path_image' => 'https://www.wribeiiro.com/players/luciano.png',
        ],
        [
            'name' => 'Geovani',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Paulinho',
            'path_image' => 'https://www.wribeiiro.com/players/paulinho.png',
        ],
        [
            'name' => 'Reginaldo',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ],
        [
            'name' => 'Renan',
            'path_image' => 'https://www.wribeiiro.com/players/renan.png',
        ],
        [
            'name' => 'Wallace',
            'path_image' => 'https://www.wribeiiro.com/players/wall.png',
        ],
        [
            'name' => 'Well',
            'path_image' => 'https://www.wribeiiro.com/players/well.png',
        ],
        [
            'name' => 'Hallan',
            'path_image' => 'https://www.wribeiiro.com/players/hallan.png',
        ],
        [
            'name' => 'Júnior',
            'path_image' => 'https://www.wribeiiro.com/players/blank.png',
        ]
    ];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        foreach (static::$playersMock as $player) {
            $findPlayer = \App\Models\Player::where('name', $player['name'])->get();

            if (!empty($findPlayer)) {
                continue;
            }

            \App\Models\Player::factory()->create([
                'name' => $player['name'],
                'path_image' => $player['path_image'],
            ]);
        }

        $players = \App\Models\Player::get();

        foreach ($players as $player) {
            $monthYear = date('m/Y');

            $findPayment = \App\Models\Payment::where([
                ['month_year', '=', $monthYear],
                ['player_id', '=', $player['id']],
            ])->get();

            if (!empty($findPayment)) {
                continue;
            }

            \App\Models\Payment::factory()->create([
                'type' => 1,
                'month_year' => $monthYear,
                'player_id' => $player['id'],
                'game_id' => null,
                'value' => 40,
                'status' => 'PAGO'
            ]);
        }
    }
}
