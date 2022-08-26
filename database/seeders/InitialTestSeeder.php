<?php

namespace Database\Seeders;

use App\Models\InitialTest;
use Illuminate\Database\Seeder;

class InitialTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InitialTest::factory()
            ->count(5)
            ->create();
    }
}
