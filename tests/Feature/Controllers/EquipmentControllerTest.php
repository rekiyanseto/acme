<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Equipment;

use App\Models\SubArea;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_equipments()
    {
        $equipments = Equipment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('equipments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.equipments.index')
            ->assertViewHas('equipments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_equipment()
    {
        $response = $this->get(route('equipments.create'));

        $response->assertOk()->assertViewIs('app.equipments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_equipment()
    {
        $data = Equipment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('equipments.store'), $data);

        $this->assertDatabaseHas('equipment', $data);

        $equipment = Equipment::latest('id')->first();

        $response->assertRedirect(route('equipments.edit', $equipment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_equipment()
    {
        $equipment = Equipment::factory()->create();

        $response = $this->get(route('equipments.show', $equipment));

        $response
            ->assertOk()
            ->assertViewIs('app.equipments.show')
            ->assertViewHas('equipment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_equipment()
    {
        $equipment = Equipment::factory()->create();

        $response = $this->get(route('equipments.edit', $equipment));

        $response
            ->assertOk()
            ->assertViewIs('app.equipments.edit')
            ->assertViewHas('equipment');
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

        $response = $this->put(route('equipments.update', $equipment), $data);

        $data['id'] = $equipment->id;

        $this->assertDatabaseHas('equipment', $data);

        $response->assertRedirect(route('equipments.edit', $equipment));
    }

    /**
     * @test
     */
    public function it_deletes_the_equipment()
    {
        $equipment = Equipment::factory()->create();

        $response = $this->delete(route('equipments.destroy', $equipment));

        $response->assertRedirect(route('equipments.index'));

        $this->assertSoftDeleted($equipment);
    }
}
