<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveySurveyResultsTest extends TestCase
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
    public function it_gets_survey_survey_results()
    {
        $survey = Survey::factory()->create();
        $surveyResults = SurveyResult::factory()
            ->count(2)
            ->create([
                'survey_id' => $survey->id,
            ]);

        $response = $this->getJson(
            route('api.surveys.survey-results.index', $survey)
        );

        $response
            ->assertOk()
            ->assertSee($surveyResults[0]->survey_result_condition);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_survey_results()
    {
        $survey = Survey::factory()->create();
        $data = SurveyResult::factory()
            ->make([
                'survey_id' => $survey->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.surveys.survey-results.store', $survey),
            $data
        );

        unset($data['survey_id']);

        $this->assertDatabaseHas('survey_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $surveyResult = SurveyResult::latest('id')->first();

        $this->assertEquals($survey->id, $surveyResult->survey_id);
    }
}
