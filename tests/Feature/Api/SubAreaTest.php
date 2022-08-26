<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubArea;

use App\Models\Area;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaTest extends TestCase
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
    public function it_gets_sub_areas_list()
    {
        $subAreas = SubArea::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sub-areas.index'));

        $response->assertOk()->assertSee($subAreas[0]->sub_area_name);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area()
    {
        $data = SubArea::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sub-areas.store'), $data);

        $this->assertDatabaseHas('sub_areas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sub_area()
    {
        $subArea = SubArea::factory()->create();

        $area = Area::factory()->create();

        $data = [
            'sub_area_name' => $this->faker->text(255),
            'sub_area_code' => $this->faker->unique->text(255),
            'sub_area_description' => $this->faker->text,
            'sub_area_site_plan' => $this->faker->text(255),
            'maintenance_by' => $this->faker->text(255),
            'area_id' => $area->id,
        ];

        $response = $this->putJson(
            route('api.sub-areas.update', $subArea),
            $data
        );

        $data['id'] = $subArea->id;

        $this->assertDatabaseHas('sub_areas', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sub_area()
    {
        $subArea = SubArea::factory()->create();

        $response = $this->deleteJson(route('api.sub-areas.destroy', $subArea));

        $this->assertSoftDeleted($subArea);

        $response->assertNoContent();
    }
}
