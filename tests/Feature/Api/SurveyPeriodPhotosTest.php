<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;
use App\Models\SurveyPeriod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyPeriodPhotosTest extends TestCase
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
    public function it_gets_survey_period_photos()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();
        $photos = Photo::factory()
            ->count(2)
            ->create([
                'survey_period_id' => $surveyPeriod->id,
            ]);

        $response = $this->getJson(
            route('api.survey-periods.photos.index', $surveyPeriod)
        );

        $response->assertOk()->assertSee($photos[0]->photo);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_period_photos()
    {
        $surveyPeriod = SurveyPeriod::factory()->create();
        $data = Photo::factory()
            ->make([
                'survey_period_id' => $surveyPeriod->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.survey-periods.photos.store', $surveyPeriod),
            $data
        );

        unset($data['sub_area_id']);
        unset($data['equipment_id']);

        $this->assertDatabaseHas('photos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $photo = Photo::latest('id')->first();

        $this->assertEquals($surveyPeriod->id, $photo->survey_period_id);
    }
}
