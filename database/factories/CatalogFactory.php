<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CatalogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'head' => $this->faker->name(),
            'a_id' => rand(0,999),
            'a_parentid' => ( rand(0,3) == 3 ? rand(0,999) : NULL ),
            // 'add_dt'
            // 'add_who'
            // 'sort' => 50
            // 'status' => 'show'
        ];
    }
}
