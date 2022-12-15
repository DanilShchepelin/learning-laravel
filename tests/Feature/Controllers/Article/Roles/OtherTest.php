<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Laravel\Sanctum\Sanctum;
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
     * @throws Exception
     */
    public function testStore(): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );
        $article = Article::factory()->create();

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
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );

        $article = Article::factory()->create(['title' => 'Hello']);

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
        Sanctum::actingAs(
            User::factory()->create(['role' => Roles::OTHER]),
            Roles::getAbilities(Roles::OTHER)
        );

        $article = Article::factory()->create();

        $this
            ->delete("/api/articles/{$article->id}")
            ->assertStatus(403);

        Article::query()->findOrFail($article->id);
    }
}
