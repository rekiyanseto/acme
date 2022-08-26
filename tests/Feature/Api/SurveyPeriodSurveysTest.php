<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyPeriodSurveysTest extends TestCase
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
    public function it_gets_survey_period_surveys()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();
        $surveys = Survey::factory()
            ->count(2)
            ->create([
                'survey_period_id' => $surveyPeriod->id,
            ]);

        $response = $this->getJson(
            route('api.survey-periods.surveys.index', $surveyPeriod)
        );

        $response->assertOk()->assertSee($surveys[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_period_surveys()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();
        $data = Survey::factory()
            ->make([
                'survey_period_id' => $surveyPeriod->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.survey-periods.surveys.store', $surveyPeriod),
            $data
        );

        $this->assertDatabaseHas('surveys', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $survey = Survey::latest('id')->first();

        $this->assertEquals($surveyPeriod->id, $survey->survey_period_id);
    }
}
