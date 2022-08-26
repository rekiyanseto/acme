<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Survey;
use App\Models\Equipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentSurveysTest extends TestCase
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
    public function it_gets_equipment_surveys()
    {
        $equipment = Equipment::factory()->create();
        $surveys = Survey::factory()
            ->count(2)
            ->create([
                'equipment_id' => $equipment->id,
            ]);

        $response = $this->getJson(
            route('api.equipments.surveys.index', $equipment)
        );

        $response->assertOk()->assertSee($surveys[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment_surveys()
    {
        $equipment = Equipment::factory()->create();
        $data = Survey::factory()
            ->make([
                'equipment_id' => $equipment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.equipments.surveys.store', $equipment),
            $data
        );

        $this->assertDatabaseHas('surveys', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $survey = Survey::latest('id')->first();

        $this->assertEquals($equipment->id, $survey->equipment_id);
    }
}
