<?php

namespace Feature\Http\Controllers;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     * @return void
     */
    public function testIndex(): void
    {
        User::factory(3)->create();
        Article::factory(10)->create();

        $response = $this->get('/api/articles');

        $response
            ->assertJsonStructure([
                'data' => [
                    '*' =>  [
                        'id',
                        'title',
                        'text',
                        'article_photo_path',
                        'announcement',
                        'slug'
                    ]
                ]
            ])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testStore(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $article = Article::factory()->create(['author_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->post('/api/articles', $article->toArray());

        $response
            ->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testShow(): void
    {
        User::factory()->create();
        $article = Article::factory()->create();
        $response = $this->get('/api/articles/' . $article->id);

        $response
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'text',
                    'article_photo_path',
                    'announcement',
                    'slug'
                ]
            ])
            ->assertJsonCount(1)
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $article = Article::factory()->create(['title' => 'Hello', 'author_id' => $user->id]);
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
        $user = User::factory()->create(['role' => Roles::Author->getName()]);
        $article = Article::factory()->create(['author_id' => $user->id]);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/articles/{$article->id}");

        $response->assertStatus(204);

        $this->expectException(ModelNotFoundException::class);
        Article::query()->findOrFail($article->id);
    }
}
