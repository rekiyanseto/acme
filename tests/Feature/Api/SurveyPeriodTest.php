<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyPeriodTest extends TestCase
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
    public function it_gets_survey_periods_list()
    {
        $surveyPeriods = SurveyPeriod::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.survey-periods.index'));

        $response->assertOk()->assertSee($surveyPeriods[0]->periode_name);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_period()
    {
        $data = SurveyPeriod::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.survey-periods.store'), $data);

        $this->assertDatabaseHas('survey_periods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_survey_period()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();

        $data = [
            'periode_name' => $this->faker->name,
            'periode_description' => $this->faker->text(255),
            'periode_status' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.survey-periods.update', $surveyPeriod),
            $data
        );

        $data['id'] = $surveyPeriod->id;

        $this->assertDatabaseHas('survey_periods', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_survey_period()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();

        $response = $this->deleteJson(
            route('api.survey-periods.destroy', $surveyPeriod)
        );

        $this->assertSoftDeleted($surveyPeriod);

        $response->assertNoContent();
    }
}
