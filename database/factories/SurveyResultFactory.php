<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SurveyResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SurveyResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'survey_result_condition' => $this->faker->text(255),
            'survey_result_note' => $this->faker->text(255),
            'survey_id' => \App\Models\Survey::factory(),
        ];
    }
}
