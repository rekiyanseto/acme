<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\SubCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubCategorySurveysTest extends TestCase
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
    public function it_gets_sub_category_surveys()
    {
        $subCategory = SubCategory::factory()->create();
        $surveys = Survey::factory()
            ->count(2)
            ->create([
                'sub_category_id' => $subCategory->id,
            ]);

        $response = $this->getJson(
            route('api.sub-categories.surveys.index', $subCategory)
        );

        $response->assertOk()->assertSee($surveys[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_category_surveys()
    {
        $subCategory = SubCategory::factory()->create();
        $data = Survey::factory()
            ->make([
                'sub_category_id' => $subCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-categories.surveys.store', $subCategory),
            $data
        );

        $this->assertDatabaseHas('surveys', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $survey = Survey::latest('id')->first();

        $this->assertEquals($subCategory->id, $survey->sub_category_id);
    }
}
