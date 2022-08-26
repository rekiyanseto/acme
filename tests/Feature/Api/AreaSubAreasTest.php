<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Area;
use App\Models\SubArea;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AreaSubAreasTest extends TestCase
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
    public function it_gets_area_sub_areas()
    {
        $area = Area::factory()->create();
        $subAreas = SubArea::factory()
            ->count(2)
            ->create([
                'area_id' => $area->id,
            ]);

        $response = $this->getJson(route('api.areas.sub-areas.index', $area));

        $response->assertOk()->assertSee($subAreas[0]->sub_area_name);
    }

    /**
     * @test
     */
    public function it_stores_the_area_sub_areas()
    {
        $area = Area::factory()->create();
        $data = SubArea::factory()
            ->make([
                'area_id' => $area->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.areas.sub-areas.store', $area),
            $data
        );

        $this->assertDatabaseHas('sub_areas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subArea = SubArea::latest('id')->first();

        $this->assertEquals($area->id, $subArea->area_id);
    }
}
