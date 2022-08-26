<?php

namespace Database\Seeders;

use App\Models\SurveyResult;
use Illuminate\Database\Seeder;

class SurveyResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SurveyResult::factory()
            ->count(5)
            ->create();
    }
}
