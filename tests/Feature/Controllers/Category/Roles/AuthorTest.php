<?php

namespace Tests\Feature\Controllers\Category\Roles;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\CreatesRegularExpressionRouteConstraints;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAuthorStore(): void
    {
        $this->actingAsAuthor();

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
        $this->actingAsAuthor();

        $category = Category::factory()->create();

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
        $this->actingAsAuthor();

        $category = Category::factory()->create();

        $response = $this
            ->delete("/api/categories/{$category->id}");

        $response->assertStatus(403);
    }
}
