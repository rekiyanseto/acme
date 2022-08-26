<?php

namespace Database\Factories;

use App\Models\Settlement;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettlementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Settlement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'settlement_note' => $this->faker->text,
            'settlement_document' => $this->faker->text(255),
            'settlement_condition' => $this->faker->text(255),
            'survey_id' => \App\Models\Survey::factory(),
        ];
    }
}
