<?php

namespace Database\Factories;

use App\Models\FundraisingProgress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FundraisingProgress>
 */
class FundraisingProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount_raised' => null,
            'confirmed_at' => null,
        ];
    }
}
