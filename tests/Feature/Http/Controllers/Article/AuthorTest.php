<?php

namespace Tests\Feature\Http\Controllers\Article;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /**
     * @return void
     */
    public function testStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $this->be($user, 'sanctum');
        $article = Article::factory()->make();

        $response = $this->post('/api/articles', $article->toArray());

        $response
            ->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $this->be($user, 'sanctum');
        $article = Article::factory()->create(['title' => 'Hello', 'author_id' => $user->id]);

        $this->postJson(
            "/api/articles/{$article->id}",
            ['title' => 'Hello2']
        )->assertStatus(200);

        $article->refresh();

        $this->assertEquals('Hello2', $article->title);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $this->be($user, 'sanctum');
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this
            ->delete("/api/articles/$article->id")
            ->assertStatus(204);

        $this->expectException(ModelNotFoundException::class);
        Article::query()->findOrFail($article->id);
    }
}
