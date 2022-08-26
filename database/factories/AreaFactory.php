<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Area::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'area_name' => $this->faker->text(255),
            'area_code' => $this->faker->unique->text(255),
            'area_site_plan' => $this->faker->text(255),
            'functional_location_id' => \App\Models\FunctionalLocation::factory(),
        ];
    }
}
