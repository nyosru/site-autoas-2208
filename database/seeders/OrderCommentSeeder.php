<?php

namespace Database\Seeders;

use App\Models\OrderComment;
use Illuminate\Database\Seeder;

class OrderCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderComment::factory()
            ->count(50)
            // ->hasPosts(1)
            ->create();
    }
}
