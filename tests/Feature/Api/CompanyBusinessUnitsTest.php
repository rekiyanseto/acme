<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\BusinessUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyBusinessUnitsTest extends TestCase
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
    public function it_gets_company_business_units()
    {
        $company = Company::factory()->create();
        $businessUnits = BusinessUnit::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.business-units.index', $company)
        );

        $response->assertOk()->assertSee($businessUnits[0]->business_unit_name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_business_units()
    {
        $company = Company::factory()->create();
        $data = BusinessUnit::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.business-units.store', $company),
            $data
        );

        $this->assertDatabaseHas('business_units', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $businessUnit = BusinessUnit::latest('id')->first();

        $this->assertEquals($company->id, $businessUnit->company_id);
    }
}
