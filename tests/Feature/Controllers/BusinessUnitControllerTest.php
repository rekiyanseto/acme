<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\BusinessUnit;

use App\Models\Company;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessUnitControllerTest extends TestCase
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
    public function it_displays_index_view_with_business_units()
    {
        $businessUnits = BusinessUnit::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('business-units.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.business_units.index')
            ->assertViewHas('businessUnits');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_business_unit()
    {
        $response = $this->get(route('business-units.create'));

        $response->assertOk()->assertViewIs('app.business_units.create');
    }

    /**
     * @test
     */
    public function it_stores_the_business_unit()
    {
        $data = BusinessUnit::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('business-units.store'), $data);

        $this->assertDatabaseHas('business_units', $data);

        $businessUnit = BusinessUnit::latest('id')->first();

        $response->assertRedirect(route('business-units.edit', $businessUnit));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $response = $this->get(route('business-units.show', $businessUnit));

        $response
            ->assertOk()
            ->assertViewIs('app.business_units.show')
            ->assertViewHas('businessUnit');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $response = $this->get(route('business-units.edit', $businessUnit));

        $response
            ->assertOk()
            ->assertViewIs('app.business_units.edit')
            ->assertViewHas('businessUnit');
    }

    /**
     * @test
     */
    public function it_updates_the_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'business_unit_name' => $this->faker->text(255),
            'business_unit_code' => $this->faker->unique->text(255),
            'business_unit_site_plan' => $this->faker->text(255),
            'company_id' => $company->id,
        ];

        $response = $this->put(
            route('business-units.update', $businessUnit),
            $data
        );

        $data['id'] = $businessUnit->id;

        $this->assertDatabaseHas('business_units', $data);

        $response->assertRedirect(route('business-units.edit', $businessUnit));
    }

    /**
     * @test
     */
    public function it_deletes_the_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $response = $this->delete(
            route('business-units.destroy', $businessUnit)
        );

        $response->assertRedirect(route('business-units.index'));

        $this->assertSoftDeleted($businessUnit);
    }
}
