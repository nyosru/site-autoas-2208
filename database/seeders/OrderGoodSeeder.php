<?php

namespace Database\Seeders;

use App\Models\OrderGood;
use Illuminate\Database\Seeder;

class OrderGoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderGood::factory()
            ->count(100)
            // ->hasPosts(1)
            ->create();
    }
}
