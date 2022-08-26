<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\SettlementByBusinessUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveySettlementByBusinessUnitsTest extends TestCase
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
    public function it_gets_survey_settlement_by_business_units()
    {
        $survey = Survey::factory()->create();
        $settlementByBusinessUnits = SettlementByBusinessUnit::factory()
            ->count(2)
            ->create([
                'survey_id' => $survey->id,
            ]);

        $response = $this->getJson(
            route('api.surveys.settlement-by-business-units.index', $survey)
        );

        $response->assertOk()->assertSee($settlementByBusinessUnits[0]->note);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_settlement_by_business_units()
    {
        $survey = Survey::factory()->create();
        $data = SettlementByBusinessUnit::factory()
            ->make([
                'survey_id' => $survey->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.surveys.settlement-by-business-units.store', $survey),
            $data
        );

        unset($data['survey_id']);

        $this->assertDatabaseHas('settlement_by_business_units', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $settlementByBusinessUnit = SettlementByBusinessUnit::latest(
            'id'
        )->first();

        $this->assertEquals($survey->id, $settlementByBusinessUnit->survey_id);
    }
}
