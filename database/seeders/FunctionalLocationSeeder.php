<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FunctionalLocation;

class FunctionalLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FunctionalLocation::factory()
            ->count(5)
            ->create();
    }
}
