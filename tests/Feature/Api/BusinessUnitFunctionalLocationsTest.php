<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BusinessUnit;
use App\Models\FunctionalLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessUnitFunctionalLocationsTest extends TestCase
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
    public function it_gets_business_unit_functional_locations()
    {
        $businessUnit = BusinessUnit::factory()->create();
        $functionalLocations = FunctionalLocation::factory()
            ->count(2)
            ->create([
                'business_unit_id' => $businessUnit->id,
            ]);

        $response = $this->getJson(
            route(
                'api.business-units.functional-locations.index',
                $businessUnit
            )
        );

        $response
            ->assertOk()
            ->assertSee($functionalLocations[0]->functional_location_name);
    }

    /**
     * @test
     */
    public function it_stores_the_business_unit_functional_locations()
    {
        $businessUnit = BusinessUnit::factory()->create();
        $data = FunctionalLocation::factory()
            ->make([
                'business_unit_id' => $businessUnit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.business-units.functional-locations.store',
                $businessUnit
            ),
            $data
        );

        $this->assertDatabaseHas('functional_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $functionalLocation = FunctionalLocation::latest('id')->first();

        $this->assertEquals(
            $businessUnit->id,
            $functionalLocation->business_unit_id
        );
    }
}
