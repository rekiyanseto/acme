<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SettlementByBusinessUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettlementByBusinessUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SettlementByBusinessUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => $this->faker->text,
            'spk_no' => $this->faker->text(255),
            'progress' => $this->faker->randomNumber(0),
            'photo' => $this->faker->text(255),
            'condition' => $this->faker->text(255),
            'survey_id' => \App\Models\Survey::factory(),
        ];
    }
}
