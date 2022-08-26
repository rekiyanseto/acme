<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\SubArea;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaSurveysTest extends TestCase
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
    public function it_gets_sub_area_surveys()
    {
        $subArea = SubArea::factory()->create();
        $surveys = Survey::factory()
            ->count(2)
            ->create([
                'sub_area_id' => $subArea->id,
            ]);

        $response = $this->getJson(
            route('api.sub-areas.surveys.index', $subArea)
        );

        $response->assertOk()->assertSee($surveys[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area_surveys()
    {
        $subArea = SubArea::factory()->create();
        $data = Survey::factory()
            ->make([
                'sub_area_id' => $subArea->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-areas.surveys.store', $subArea),
            $data
        );

        $this->assertDatabaseHas('surveys', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $survey = Survey::latest('id')->first();

        $this->assertEquals($subArea->id, $survey->sub_area_id);
    }
}
