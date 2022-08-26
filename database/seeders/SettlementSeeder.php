<?php

namespace Database\Seeders;

use App\Models\Settlement;
use Illuminate\Database\Seeder;

class SettlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settlement::factory()
            ->count(5)
            ->create();
    }
}
