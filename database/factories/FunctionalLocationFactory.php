<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FunctionalLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class FunctionalLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FunctionalLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'functional_location_name' => $this->faker->text(255),
            'functional_location_code' => $this->faker->unique->text(255),
            'functional_location_site_plan' => $this->faker->text(255),
            'business_unit_id' => \App\Models\BusinessUnit::factory(),
        ];
    }
}
