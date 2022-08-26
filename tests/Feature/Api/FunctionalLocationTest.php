<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FunctionalLocation;

use App\Models\BusinessUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FunctionalLocationTest extends TestCase
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
    public function it_gets_functional_locations_list()
    {
        $functionalLocations = FunctionalLocation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.functional-locations.index'));

        $response
            ->assertOk()
            ->assertSee($functionalLocations[0]->functional_location_name);
    }

    /**
     * @test
     */
    public function it_stores_the_functional_location()
    {
        $data = FunctionalLocation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.functional-locations.store'),
            $data
        );

        $this->assertDatabaseHas('functional_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_functional_location()
    {
        $functionalLocation = FunctionalLocation::factory()->create();

        $businessUnit = BusinessUnit::factory()->create();

        $data = [
            'functional_location_name' => $this->faker->text(255),
            'functional_location_code' => $this->faker->unique->text(255),
            'functional_location_site_plan' => $this->faker->text(255),
            'business_unit_id' => $businessUnit->id,
        ];

        $response = $this->putJson(
            route('api.functional-locations.update', $functionalLocation),
            $data
        );

        $data['id'] = $functionalLocation->id;

        $this->assertDatabaseHas('functional_locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_functional_location()
    {
        $functionalLocation = FunctionalLocation::factory()->create();

        $response = $this->deleteJson(
            route('api.functional-locations.destroy', $functionalLocation)
        );

        $this->assertSoftDeleted($functionalLocation);

        $response->assertNoContent();
    }
}
