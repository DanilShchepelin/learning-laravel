<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
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
    public function testStore(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::AUTHOR]),
            Roles::getAbilities(Roles::AUTHOR)
        );

        $article = Article::factory()->make();

        $this
            ->postJson('/api/articles', $article->toArray())
            ->assertStatus(201);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );

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
     * @throws Exception
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );

        $article = Article::factory()->create(['author_id' => $user->id]);

        $this
            ->delete("/api/articles/$article->id")
            ->assertStatus(204);
    }
}
