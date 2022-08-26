<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubCategory;

use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubCategoryTest extends TestCase
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
    public function it_gets_sub_categories_list()
    {
        $subCategories = SubCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sub-categories.index'));

        $response->assertOk()->assertSee($subCategories[0]->category_name);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_category()
    {
        $data = SubCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sub-categories.store'), $data);

        $this->assertDatabaseHas('sub_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $category = Category::factory()->create();

        $data = [
            'category_name' => $this->faker->text(255),
            'category_code' => $this->faker->unique->text(255),
            'category_id' => $category->id,
        ];

        $response = $this->putJson(
            route('api.sub-categories.update', $subCategory),
            $data
        );

        $data['id'] = $subCategory->id;

        $this->assertDatabaseHas('sub_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sub_category()
    {
        $subCategory = SubCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.sub-categories.destroy', $subCategory)
        );

        $this->assertSoftDeleted($subCategory);

        $response->assertNoContent();
    }
}
