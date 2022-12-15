<?php

namespace Tests\Feature\Controllers\Category\Roles;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Exception;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testCanAuthorStore(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::AUTHOR]),
            Roles::getAbilities(Roles::AUTHOR)
        );

        $category = Category::factory()->make();

        $response = $this
            ->post('/api/categories', $category->toArray());

        $response->assertStatus(403);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAuthorUpdate(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::AUTHOR]),
            Roles::getAbilities(Roles::AUTHOR)
        );

        $category = Category::factory()->create(['title' => 'Hello']);

        $response = $this->post("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertStatus(403);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAuthorDestroy(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::AUTHOR]),
            Roles::getAbilities(Roles::AUTHOR)
        );

        $category = Category::factory()->create();

        $response = $this
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(403);
    }
}
