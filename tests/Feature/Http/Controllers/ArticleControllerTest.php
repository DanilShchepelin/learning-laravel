<?php

namespace Tests\Feature\Http\Controllers;

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
        User::factory()->create();
        $article = Article::factory()->make();
        $response = $this->post('/api/articles', $article->toArray());

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
        User::factory()->create();
        $article = Article::factory()->create(['title' => 'Hello']);
        $response = $this->put("/api/articles/{$article->id}", ['title' => 'Hello2']);

        $response
            ->assertJsonFragment(['title' => 'Hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        User::factory()->create();
        $article = Article::factory()->create();

        $response = $this->delete("/api/articles/{$article->id}");

        $response->assertStatus(204);

        $this->expectException(ModelNotFoundException::class);
        Article::query()->findOrFail($article->id);
    }
}
