<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;
use App\Models\Equipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentPhotosTest extends TestCase
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
    public function it_gets_equipment_photos()
    {
        $equipment = Equipment::factory()->create();
        $photos = Photo::factory()
            ->count(2)
            ->create([
                'equipment_id' => $equipment->id,
            ]);

        $response = $this->getJson(
            route('api.equipments.photos.index', $equipment)
        );

        $response->assertOk()->assertSee($photos[0]->photo);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment_photos()
    {
        $equipment = Equipment::factory()->create();
        $data = Photo::factory()
            ->make([
                'equipment_id' => $equipment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.equipments.photos.store', $equipment),
            $data
        );

        unset($data['sub_area_id']);
        unset($data['equipment_id']);

        $this->assertDatabaseHas('photos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $photo = Photo::latest('id')->first();

        $this->assertEquals($equipment->id, $photo->equipment_id);
    }
}
