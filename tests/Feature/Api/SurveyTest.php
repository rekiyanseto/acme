<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;

use App\Models\SubArea;
use App\Models\Equipment;
use App\Models\SubCategory;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyTest extends TestCase
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
    public function it_gets_surveys_list()
    {
        $surveys = Survey::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.surveys.index'));

        $response->assertOk()->assertSee($surveys[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_survey()
    {
        $data = Survey::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.surveys.store'), $data);

        $this->assertDatabaseHas('surveys', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.surveys.update', $survey), $data);

        $data['id'] = $survey->id;

        $this->assertDatabaseHas('surveys', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->deleteJson(route('api.surveys.destroy', $survey));

        $this->assertSoftDeleted($survey);

        $response->assertNoContent();
    }
}
