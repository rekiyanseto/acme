<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Survey;

use App\Models\SubArea;
use App\Models\Equipment;
use App\Models\SubCategory;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyControllerTest extends TestCase
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
    public function it_displays_index_view_with_surveys()
    {
        $surveys = Survey::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('surveys.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.surveys.index')
            ->assertViewHas('surveys');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_survey()
    {
        $response = $this->get(route('surveys.create'));

        $response->assertOk()->assertViewIs('app.surveys.create');
    }

    /**
     * @test
     */
    public function it_stores_the_survey()
    {
        $data = Survey::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('surveys.store'), $data);

        $this->assertDatabaseHas('surveys', $data);

        $survey = Survey::latest('id')->first();

        $response->assertRedirect(route('surveys.edit', $survey));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->get(route('surveys.show', $survey));

        $response
            ->assertOk()
            ->assertViewIs('app.surveys.show')
            ->assertViewHas('survey');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->get(route('surveys.edit', $survey));

        $response
            ->assertOk()
            ->assertViewIs('app.surveys.edit')
            ->assertViewHas('survey');
    }

    /**
     * @test
     */
    public function it_updates_the_survey()
    {
        $survey = Survey::factory()->create();

        $surveyPeriod = SurveyPeriod::factory()->create();
        $subArea = SubArea::factory()->create();
        $equipment = Equipment::factory()->create();
        $subCategory = SubCategory::factory()->create();

        $data = [
            'survey_period_id' => $surveyPeriod->id,
            'sub_area_id' => $subArea->id,
            'equipment_id' => $equipment->id,
            'sub_category_id' => $subCategory->id,
        ];

        $response = $this->put(route('surveys.update', $survey), $data);

        $data['id'] = $survey->id;

        $this->assertDatabaseHas('surveys', $data);

        $response->assertRedirect(route('surveys.edit', $survey));
    }

    /**
     * @test
     */
    public function it_deletes_the_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->delete(route('surveys.destroy', $survey));

        $response->assertRedirect(route('surveys.index'));

        $this->assertSoftDeleted($survey);
    }
}
