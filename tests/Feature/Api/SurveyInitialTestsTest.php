<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\InitialTest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyInitialTestsTest extends TestCase
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
    public function it_gets_survey_initial_tests()
    {
        $survey = Survey::factory()->create();
        $initialTests = InitialTest::factory()
            ->count(2)
            ->create([
                'survey_id' => $survey->id,
            ]);

        $response = $this->getJson(
            route('api.surveys.initial-tests.index', $survey)
        );

        $response->assertOk()->assertSee($initialTests[0]->initial_test_tool);
    }

    /**
     * @test
     */
    public function it_stores_the_survey_initial_tests()
    {
        $survey = Survey::factory()->create();
        $data = InitialTest::factory()
            ->make([
                'survey_id' => $survey->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.surveys.initial-tests.store', $survey),
            $data
        );

        unset($data['survey_id']);

        $this->assertDatabaseHas('initial_tests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $initialTest = InitialTest::latest('id')->first();

        $this->assertEquals($survey->id, $initialTest->survey_id);
    }
}
