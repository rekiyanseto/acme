<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubArea;
use App\Models\MaintenanceDocument;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaMaintenanceDocumentsTest extends TestCase
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
    public function it_gets_sub_area_maintenance_documents()
    {
        $subArea = SubArea::factory()->create();
        $maintenanceDocuments = MaintenanceDocument::factory()
            ->count(2)
            ->create([
                'sub_area_id' => $subArea->id,
            ]);

        $response = $this->getJson(
            route('api.sub-areas.maintenance-documents.index', $subArea)
        );

        $response
            ->assertOk()
            ->assertSee($maintenanceDocuments[0]->document_name);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area_maintenance_documents()
    {
        $subArea = SubArea::factory()->create();
        $data = MaintenanceDocument::factory()
            ->make([
                'sub_area_id' => $subArea->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-areas.maintenance-documents.store', $subArea),
            $data
        );

        unset($data['sub_area_id']);
        unset($data['equipment_id']);

        $this->assertDatabaseHas('maintenance_documents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $maintenanceDocument = MaintenanceDocument::latest('id')->first();

        $this->assertEquals($subArea->id, $maintenanceDocument->sub_area_id);
    }
}
