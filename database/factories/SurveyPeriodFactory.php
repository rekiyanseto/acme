<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SurveyPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyPeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SurveyPeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'periode_name' => $this->faker->name,
            'periode_description' => $this->faker->text(255),
            'periode_status' => $this->faker->text(255),
        ];
    }
}
