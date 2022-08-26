<?php

namespace Database\Seeders;

use App\Models\SurveyPeriod;
use Illuminate\Database\Seeder;

class SurveyPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SurveyPeriod::factory()
            ->count(5)
            ->create();
    }
}
