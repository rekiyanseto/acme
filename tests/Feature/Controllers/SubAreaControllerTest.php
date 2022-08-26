<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SubArea;

use App\Models\Area;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaControllerTest extends TestCase
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
    public function it_displays_index_view_with_sub_areas()
    {
        $subAreas = SubArea::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sub-areas.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sub_areas.index')
            ->assertViewHas('subAreas');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sub_area()
    {
        $response = $this->get(route('sub-areas.create'));

        $response->assertOk()->assertViewIs('app.sub_areas.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area()
    {
        $data = SubArea::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sub-areas.store'), $data);

        $this->assertDatabaseHas('sub_areas', $data);

        $subArea = SubArea::latest('id')->first();

        $response->assertRedirect(route('sub-areas.edit', $subArea));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sub_area()
    {
        $subArea = SubArea::factory()->create();

        $response = $this->get(route('sub-areas.show', $subArea));

        $response
            ->assertOk()
            ->assertViewIs('app.sub_areas.show')
            ->assertViewHas('subArea');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sub_area()
    {
        $subArea = SubArea::factory()->create();

        $response = $this->get(route('sub-areas.edit', $subArea));

        $response
            ->assertOk()
            ->assertViewIs('app.sub_areas.edit')
            ->assertViewHas('subArea');
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

        $response = $this->put(route('sub-areas.update', $subArea), $data);

        $data['id'] = $subArea->id;

        $this->assertDatabaseHas('sub_areas', $data);

        $response->assertRedirect(route('sub-areas.edit', $subArea));
    }

    /**
     * @test
     */
    public function it_deletes_the_sub_area()
    {
        $subArea = SubArea::factory()->create();

        $response = $this->delete(route('sub-areas.destroy', $subArea));

        $response->assertRedirect(route('sub-areas.index'));

        $this->assertSoftDeleted($subArea);
    }
}
