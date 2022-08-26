<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Equipment;

use App\Models\SubArea;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_equipments_list()
    {
        $equipments = Equipment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.equipments.index'));

        $response->assertOk()->assertSee($equipments[0]->equipment_name);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment()
    {
        $data = Equipment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.equipments.store'), $data);

        $this->assertDatabaseHas('equipment', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_equipment()
    {
        $equipment = Equipment::factory()->create();

        $subArea = SubArea::factory()->create();

        $data = [
            'equipment_name' => $this->faker->text(255),
            'equipment_code' => $this->faker->unique->text(255),
            'equipment_description' => $this->faker->text,
            'maintenance_by' => $this->faker->text(255),
            'sub_area_id' => $subArea->id,
        ];

        $response = $this->putJson(
            route('api.equipments.update', $equipment),
            $data
        );

        $data['id'] = $equipment->id;

        $this->assertDatabaseHas('equipment', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_equipment()
    {
        $equipment = Equipment::factory()->create();

        $response = $this->deleteJson(
            route('api.equipments.destroy', $equipment)
        );

        $this->assertSoftDeleted($equipment);

        $response->assertNoContent();
    }
}
