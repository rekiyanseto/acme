<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FunctionalLocation;

use App\Models\BusinessUnit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FunctionalLocationControllerTest extends TestCase
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
    public function it_displays_index_view_with_functional_locations()
    {
        $functionalLocations = FunctionalLocation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('functional-locations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.functional_locations.index')
            ->assertViewHas('functionalLocations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_functional_location()
    {
        $response = $this->get(route('functional-locations.create'));

        $response->assertOk()->assertViewIs('app.functional_locations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_functional_location()
    {
        $data = FunctionalLocation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('functional-locations.store'), $data);

        $this->assertDatabaseHas('functional_locations', $data);

        $functionalLocation = FunctionalLocation::latest('id')->first();

        $response->assertRedirect(
            route('functional-locations.edit', $functionalLocation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_functional_location()
    {
        $functionalLocation = FunctionalLocation::factory()->create();

        $response = $this->get(
            route('functional-locations.show', $functionalLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.functional_locations.show')
            ->assertViewHas('functionalLocation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_functional_location()
    {
        $functionalLocation = FunctionalLocation::factory()->create();

        $response = $this->get(
            route('functional-locations.edit', $functionalLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.functional_locations.edit')
            ->assertViewHas('functionalLocation');
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

        $response = $this->put(
            route('functional-locations.update', $functionalLocation),
            $data
        );

        $data['id'] = $functionalLocation->id;

        $this->assertDatabaseHas('functional_locations', $data);

        $response->assertRedirect(
            route('functional-locations.edit', $functionalLocation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_functional_location()
    {
        $functionalLocation = FunctionalLocation::factory()->create();

        $response = $this->delete(
            route('functional-locations.destroy', $functionalLocation)
        );

        $response->assertRedirect(route('functional-locations.index'));

        $this->assertSoftDeleted($functionalLocation);
    }
}
