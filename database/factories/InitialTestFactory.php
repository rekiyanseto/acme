<?php

namespace Database\Factories;

use App\Models\InitialTest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InitialTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InitialTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'initial_test_tool' => $this->faker->text(255),
            'initial_test_result' => $this->faker->text(255),
            'initial_test_standard' => $this->faker->text(255),
            'initial_test_note' => $this->faker->text,
            'survey_id' => \App\Models\Survey::factory(),
        ];
    }
}
