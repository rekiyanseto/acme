<?php

namespace Database\Seeders;

use App\Models\SubArea;
use Illuminate\Database\Seeder;

class SubAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubArea::factory()
            ->count(5)
            ->create();
    }
}
