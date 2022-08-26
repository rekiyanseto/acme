<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;
use App\Models\SubArea;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaPhotosTest extends TestCase
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
    public function it_gets_sub_area_photos()
    {
        $subArea = SubArea::factory()->create();
        $photos = Photo::factory()
            ->count(2)
            ->create([
                'sub_area_id' => $subArea->id,
            ]);

        $response = $this->getJson(
            route('api.sub-areas.photos.index', $subArea)
        );

        $response->assertOk()->assertSee($photos[0]->photo);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area_photos()
    {
        $subArea = SubArea::factory()->create();
        $data = Photo::factory()
            ->make([
                'sub_area_id' => $subArea->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-areas.photos.store', $subArea),
            $data
        );

        unset($data['sub_area_id']);
        unset($data['equipment_id']);

        $this->assertDatabaseHas('photos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $photo = Photo::latest('id')->first();

        $this->assertEquals($subArea->id, $photo->sub_area_id);
    }
}
