<?php

namespace Tests\Feature\Controllers\Category\Roles;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OtherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex(): void
    {
        Category::factory(10)->create();

        $response = $this->get('/api/categories');

        $response
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug'
                    ]
                ]
            ])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShow(): void
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/categories/' . $category->id);

        $response
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug'
                ]
            ])
            ->assertJsonCount(1)
            ->assertStatus(200);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanOtherStore(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );

        $category = Category::factory()->create();

        $response = $this->post('/api/categories', $category->toArray());

        $response->assertStatus(403);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanOtherUpdate(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );

        $category = Category::factory()->create(['title' => 'Hello']);

        $response = $this
            ->post("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertStatus(403);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanOtherDestroy(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );

        $category = Category::factory()->create();

        $response = $this
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(403);
    }
}
