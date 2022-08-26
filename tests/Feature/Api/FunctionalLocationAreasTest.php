<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Area;
use App\Models\FunctionalLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FunctionalLocationAreasTest extends TestCase
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
    public function it_gets_functional_location_areas()
    {
        $functionalLocation = FunctionalLocation::factory()->create();
        $areas = Area::factory()
            ->count(2)
            ->create([
                'functional_location_id' => $functionalLocation->id,
            ]);

        $response = $this->getJson(
            route('api.functional-locations.areas.index', $functionalLocation)
        );

        $response->assertOk()->assertSee($areas[0]->area_name);
    }

    /**
     * @test
     */
    public function it_stores_the_functional_location_areas()
    {
        $functionalLocation = FunctionalLocation::factory()->create();
        $data = Area::factory()
            ->make([
                'functional_location_id' => $functionalLocation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.functional-locations.areas.store', $functionalLocation),
            $data
        );

        $this->assertDatabaseHas('areas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $area = Area::latest('id')->first();

        $this->assertEquals(
            $functionalLocation->id,
            $area->functional_location_id
        );
    }
}
