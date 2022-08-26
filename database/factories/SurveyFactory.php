<?php

namespace Database\Factories;

use App\Models\Survey;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'survey_period_id' => \App\Models\SurveyPeriod::factory(),
            'sub_area_id' => \App\Models\SubArea::factory(),
            'equipment_id' => \App\Models\Equipment::factory(),
            'sub_category_id' => \App\Models\SubCategory::factory(),
        ];
    }
}
