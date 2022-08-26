<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\Settlement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveySettlementsTest extends TestCase
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
    public function it_gets_survey_settlements()
    {
        $survey = Survey::factory()->create();
        $settlements = Settlement::factory()
            ->count(2)
            ->create([
                'survey_id' => $survey->id,
            ]);

        $response = $this->getJson(
            route('api.surveys.settlements.index', $survey)
        );

        $response->assertOk()->assertSee($settlements[0]->settlement_note);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_settlements()
    {
        $survey = Survey::factory()->create();
        $data = Settlement::factory()
            ->make([
                'survey_id' => $survey->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.surveys.settlements.store', $survey),
            $data
        );

        unset($data['survey_id']);

        $this->assertDatabaseHas('settlements', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $settlement = Settlement::latest('id')->first();

        $this->assertEquals($survey->id, $settlement->survey_id);
    }
}
