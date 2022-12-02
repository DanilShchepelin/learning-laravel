<?php

namespace Feature\Http\Controllers;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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
     */
    public function testStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post('/api/categories', $category->toArray());

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $category = Category::factory()->create(['title' => 'Hello']);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertJsonFragment(['title' => 'hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);
        Category::query()->findOrFail($category->id);
    }
}
