<?php

namespace Tests\Feature\Http\Controllers\Category;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanAuthorStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $category = Category::factory()->make();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post('/api/categories', $category->toArray());

        $response->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testCanAuthorUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
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
    public function testCanAuthorDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(403);
    }
}
