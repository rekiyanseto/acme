<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubArea;
use App\Models\Equipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaEquipmentsTest extends TestCase
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
    public function it_gets_sub_area_equipments()
    {
        $subArea = SubArea::factory()->create();
        $equipments = Equipment::factory()
            ->count(2)
            ->create([
                'sub_area_id' => $subArea->id,
            ]);

        $response = $this->getJson(
            route('api.sub-areas.equipments.index', $subArea)
        );

        $response->assertOk()->assertSee($equipments[0]->equipment_name);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area_equipments()
    {
        $subArea = SubArea::factory()->create();
        $data = Equipment::factory()
            ->make([
                'sub_area_id' => $subArea->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-areas.equipments.store', $subArea),
            $data
        );

        $this->assertDatabaseHas('equipment', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $equipment = Equipment::latest('id')->first();

        $this->assertEquals($subArea->id, $equipment->sub_area_id);
    }
}
