<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;
use App\Models\Survey;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyPhotosTest extends TestCase
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
    public function it_gets_survey_photos()
    {
        $survey = Survey::factory()->create();
        $photos = Photo::factory()
            ->count(2)
            ->create([
                'survey_id' => $survey->id,
            ]);

        $response = $this->getJson(route('api.surveys.photos.index', $survey));

        $response->assertOk()->assertSee($photos[0]->photo);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_photos()
    {
        $survey = Survey::factory()->create();
        $data = Photo::factory()
            ->make([
                'survey_id' => $survey->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.surveys.photos.store', $survey),
            $data
        );

        unset($data['survey_id']);

        $this->assertDatabaseHas('photos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $photo = Photo::latest('id')->first();

        $this->assertEquals($survey->id, $photo->survey_id);
    }
}
