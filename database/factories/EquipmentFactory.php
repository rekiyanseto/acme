<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'equipment_name' => $this->faker->text(255),
            'equipment_code' => $this->faker->unique->text(255),
            'equipment_description' => $this->faker->text,
            'maintenance_by' => $this->faker->text(255),
            'sub_area_id' => \App\Models\SubArea::factory(),
        ];
    }
}
