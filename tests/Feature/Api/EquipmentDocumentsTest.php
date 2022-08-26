<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Document;
use App\Models\Equipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentDocumentsTest extends TestCase
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
    public function it_gets_equipment_documents()
    {
        $equipment = Equipment::factory()->create();
        $documents = Document::factory()
            ->count(2)
            ->create([
                'equipment_id' => $equipment->id,
            ]);

        $response = $this->getJson(
            route('api.equipments.documents.index', $equipment)
        );

        $response->assertOk()->assertSee($documents[0]->document_name);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment_documents()
    {
        $equipment = Equipment::factory()->create();
        $data = Document::factory()
            ->make([
                'equipment_id' => $equipment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.equipments.documents.store', $equipment),
            $data
        );

        unset($data['equipment_id']);
        unset($data['sub_area_id']);

        $this->assertDatabaseHas('documents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $document = Document::latest('id')->first();

        $this->assertEquals($equipment->id, $document->equipment_id);
    }
}
