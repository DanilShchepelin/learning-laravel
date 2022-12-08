<?php

namespace Tests\Feature\Http\Controllers\Category;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanAdminStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $category = Category::factory()->make();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->post('/api/categories', $category->toArray());

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testCanAdminUpdate(): void
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
    public function testCanAdminDestroy(): void
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
