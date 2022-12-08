<?php

namespace Tests\Feature\Http\Controllers\Article;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtherTest extends TestCase
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
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $article = Article::factory()->create();

        $this
            ->actingAs($user, 'sanctum')
            ->post('/api/articles', $article->toArray())
            ->assertStatus(403);

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
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $article = Article::factory()->create(['title' => 'Hello']);
        $this
            ->actingAs($user, 'sanctum')
            ->post("/api/articles/{$article->id}", ['title' => 'Hello2'])
            ->assertStatus(403);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Other->getName()]);
        $article = Article::factory()->create();

        $this
            ->actingAs($user, 'sanctum')
            ->delete("/api/articles/{$article->id}")
            ->assertStatus(403);

        $this->expectException(ModelNotFoundException::class);
        Article::query()->findOrFail($article->id);
    }
}
