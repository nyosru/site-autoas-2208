<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
             "head" => $this->faker->name(),
             "a_id" => $this->faker->lexify('??????????'),
            //  "a_categoryid",
             "a_catnumber" => $this->faker->word(),
             "catnumber_search"  => $this->faker->word(),
             "a_price" => 100,
             "a_in_stock" => 9,
            //  "a_arrayimage",
            //  "country",
            //  "manufacturer",
            //  "comment"
        ];
    }
}
