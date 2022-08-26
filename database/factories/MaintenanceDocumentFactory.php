<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MaintenanceDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaintenanceDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_name' => $this->faker->text(255),
            'document_remarks' => $this->faker->text,
            'document_file' => $this->faker->text(255),
            'sub_area_id' => \App\Models\SubArea::factory(),
            'equipment_id' => \App\Models\Equipment::factory(),
        ];
    }
}
