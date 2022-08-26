<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyPeriodControllerTest extends TestCase
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
    public function it_displays_index_view_with_survey_periods()
    {
        $surveyPeriods = SurveyPeriod::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('survey-periods.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.survey_periods.index')
            ->assertViewHas('surveyPeriods');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_survey_period()
    {
        $response = $this->get(route('survey-periods.create'));

        $response->assertOk()->assertViewIs('app.survey_periods.create');
    }

    /**
     * @test
     */
    public function it_stores_the_survey_period()
    {
        $data = SurveyPeriod::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('survey-periods.store'), $data);

        $this->assertDatabaseHas('survey_periods', $data);

        $surveyPeriod = SurveyPeriod::latest('id')->first();

        $response->assertRedirect(route('survey-periods.edit', $surveyPeriod));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_survey_period()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();

        $response = $this->get(route('survey-periods.show', $surveyPeriod));

        $response
            ->assertOk()
            ->assertViewIs('app.survey_periods.show')
            ->assertViewHas('surveyPeriod');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_survey_period()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();

        $response = $this->get(route('survey-periods.edit', $surveyPeriod));

        $response
            ->assertOk()
            ->assertViewIs('app.survey_periods.edit')
            ->assertViewHas('surveyPeriod');
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

        $response = $this->put(
            route('survey-periods.update', $surveyPeriod),
            $data
        );

        $data['id'] = $surveyPeriod->id;

        $this->assertDatabaseHas('survey_periods', $data);

        $response->assertRedirect(route('survey-periods.edit', $surveyPeriod));
    }

    /**
     * @test
     */
    public function it_deletes_the_survey_period()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();

        $response = $this->delete(
            route('survey-periods.destroy', $surveyPeriod)
        );

        $response->assertRedirect(route('survey-periods.index'));

        $this->assertSoftDeleted($surveyPeriod);
    }
}
