<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubArea;
use App\Models\Document;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubAreaDocumentsTest extends TestCase
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
    public function it_gets_sub_area_documents()
    {
        $subArea = SubArea::factory()->create();
        $documents = Document::factory()
            ->count(2)
            ->create([
                'sub_area_id' => $subArea->id,
            ]);

        $response = $this->getJson(
            route('api.sub-areas.documents.index', $subArea)
        );

        $response->assertOk()->assertSee($documents[0]->document_name);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_area_documents()
    {
        $subArea = SubArea::factory()->create();
        $data = Document::factory()
            ->make([
                'sub_area_id' => $subArea->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-areas.documents.store', $subArea),
            $data
        );

        unset($data['equipment_id']);
        unset($data['sub_area_id']);

        $this->assertDatabaseHas('documents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $document = Document::latest('id')->first();

        $this->assertEquals($subArea->id, $document->sub_area_id);
    }
}
