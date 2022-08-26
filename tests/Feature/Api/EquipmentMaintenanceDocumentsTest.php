<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Equipment;
use App\Models\MaintenanceDocument;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentMaintenanceDocumentsTest extends TestCase
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
    public function it_gets_equipment_maintenance_documents()
    {
        $equipment = Equipment::factory()->create();
        $maintenanceDocuments = MaintenanceDocument::factory()
            ->count(2)
            ->create([
                'equipment_id' => $equipment->id,
            ]);

        $response = $this->getJson(
            route('api.equipments.maintenance-documents.index', $equipment)
        );

        $response
            ->assertOk()
            ->assertSee($maintenanceDocuments[0]->document_name);
    }

    /**
     * @test
     */
    public function it_stores_the_equipment_maintenance_documents()
    {
        $equipment = Equipment::factory()->create();
        $data = MaintenanceDocument::factory()
            ->make([
                'equipment_id' => $equipment->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.equipments.maintenance-documents.store', $equipment),
            $data
        );

        unset($data['sub_area_id']);
        unset($data['equipment_id']);

        $this->assertDatabaseHas('maintenance_documents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $maintenanceDocument = MaintenanceDocument::latest('id')->first();

        $this->assertEquals($equipment->id, $maintenanceDocument->equipment_id);
    }
}
