<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     * @throws Exception
     */
    public function testStore(): void
    {
        User::factory(4)->create();
        $user_id = $this->actingAsAuthor();

        $article = [
            'title' => $this->faker->title,
            'text' => $this->faker->text
        ];

        $response = $this
            ->postJson('/api/articles', $article)
            ->assertStatus(201);

        $this->assertEquals($user_id, $response['article']['author_id']);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $user_id = $this->actingAsAuthor();

        $article = Article::factory()->create(['author_id' => $user_id]);

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
        $user_id = $this->actingAsAuthor();

        $article = Article::factory()->create(['author_id' => $user_id]);

        $this
            ->delete("/api/articles/$article->id")
            ->assertStatus(204);

        $this->assertModelMissing($article);
    }
}
