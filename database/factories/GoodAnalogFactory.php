<?php

namespace Database\Factories;

use App\Models\Good;
use Illuminate\Database\Eloquent\Factories\Factory;


class GoodAnalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        // $g = Good::limit(7)->get();
        return [
            // 'art_origin' => $this->faker->word(),
            'art_origin' => Good::first()->a_id,
            // 'art_origin' => Good::factory()->a_id,
            'art_analog' => Good::inRandomOrder()->first()->a_id,
        ];
    }
}
