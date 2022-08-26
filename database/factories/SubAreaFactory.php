<?php

namespace Database\Factories;

use App\Models\SubArea;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubAreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubArea::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sub_area_name' => $this->faker->text(255),
            'sub_area_code' => $this->faker->unique->text(255),
            'sub_area_description' => $this->faker->text,
            'sub_area_site_plan' => $this->faker->text(255),
            'maintenance_by' => $this->faker->text(255),
            'area_id' => \App\Models\Area::factory(),
        ];
    }
}
