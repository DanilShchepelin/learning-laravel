<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @return void
     */
    public function testIndex(): void
    {
        $user = User::factory()->create();
        Article::factory(10)->create(['author_id' => $user->id]);

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
    public function testShow(): void
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        $article = Article::factory()->create(['author_id' => $user->id]);

        $response = $this->get("/api/articles/{$article->id}");

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
     * @throws Exception
     */
    public function testStore(): void
    {
        User::factory()->create();
        $this->actingAsOther();

        $article = Article::factory()->make();

        $this
            ->post('/api/articles', $article->toArray())
            ->assertStatus(403);

    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $this->actingAsOther();
        $author = User::factory()->create(['role' => Roles::AUTHOR]);
        $article = Article::factory()->create(['author_id' => $author->id]);

        $this
            ->post("/api/articles/{$article->id}", ['title' => 'Hello2'])
            ->assertStatus(403);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testDestroy(): void
    {
        $this->actingAsOther();
        $author = User::factory()->create(['role' => Roles::AUTHOR]);
        $article = Article::factory()->create(['author_id' => $author->id]);

        $this
            ->delete("/api/articles/{$article->id}")
            ->assertStatus(403);

        Article::query()->findOrFail($article->id);
    }
}
