<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 1,
            'month_year' => date('m-Y'),
            'player_id' => 1,
            'game_id' => null,
            'value' => 40,
            'status' => 'NÃO PAGO'
        ];
    }
}
