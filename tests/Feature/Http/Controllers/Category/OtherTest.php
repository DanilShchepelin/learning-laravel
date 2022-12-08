<?php

namespace Tests\Feature\Http\Controllers\Category;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
     */
    public function testCanOtherStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post('/api/categories', $category->toArray());

        $response->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testCanOtherUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $category = Category::factory()->create(['title' => 'Hello']);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testCanOtherDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(403);
    }
}
