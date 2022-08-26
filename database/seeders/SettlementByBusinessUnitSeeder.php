<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettlementByBusinessUnit;

class SettlementByBusinessUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettlementByBusinessUnit::factory()
            ->count(5)
            ->create();
    }
}
