<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\BusinessUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessUnitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusinessUnit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'business_unit_name' => $this->faker->text(255),
            'business_unit_code' => $this->faker->unique->text(255),
            'business_unit_site_plan' => $this->faker->text(255),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
