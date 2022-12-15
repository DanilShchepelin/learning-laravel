<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testStore(): void
    {
        $this->actingAsAdmin();
        $article = Article::factory()->make();

        $this
            ->post('/api/articles', $article->toArray())
            ->assertStatus(201);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $this->actingAsAdmin();

        $article = Article::factory()->create(['title' => 'Hello']);

        $response = $this->post("/api/articles/{$article->id}", ['title' => 'Hello2']);

        $response
            ->assertJsonFragment(['title' => 'Hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testDestroy(): void
    {
        $this->actingAsAdmin();

        $article = Article::factory()->create();

        $response = $this->delete("/api/articles/{$article->id}");

        $response->assertStatus(204);
    }
}
