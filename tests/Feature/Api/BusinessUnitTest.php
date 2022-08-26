<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BusinessUnit;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessUnitTest extends TestCase
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
    public function it_gets_business_units_list()
    {
        $businessUnits = BusinessUnit::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.business-units.index'));

        $response->assertOk()->assertSee($businessUnits[0]->business_unit_name);
    }

    /**
     * @test
     */
    public function it_stores_the_business_unit()
    {
        $data = BusinessUnit::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.business-units.store'), $data);

        $this->assertDatabaseHas('business_units', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.business-units.update', $businessUnit),
            $data
        );

        $data['id'] = $businessUnit->id;

        $this->assertDatabaseHas('business_units', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $response = $this->deleteJson(
            route('api.business-units.destroy', $businessUnit)
        );

        $this->assertSoftDeleted($businessUnit);

        $response->assertNoContent();
    }
}
