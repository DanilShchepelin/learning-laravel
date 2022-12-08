<?php

namespace Tests\Feature\Http\Controllers\Article;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @return void
     */
    public function testStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $this->be($user, 'sanctum');
        $article = Article::factory()->make();

        $this
            ->post('/api/articles', $article->toArray())
            ->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $article = Article::factory()->create(['title' => 'Hello']);
        $response = $this
            ->actingAs($user, 'sanctum')
            ->post("/api/articles/{$article->id}", ['title' => 'Hello2']);

        $response
            ->assertJsonFragment(['title' => 'Hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);
        $article = Article::factory()->create();

        $response = $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/articles/{$article->id}");

        $response->assertStatus(204);

        $this->expectException(ModelNotFoundException::class);
        Article::query()->findOrFail($article->id);
    }
}
