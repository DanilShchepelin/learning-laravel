<?php

namespace Tests\Feature\Controllers\Article\Resource;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScopeWithAuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testResourceWithAuthor(): void
    {
        $author = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $author->id]);

        $this
            ->get("api/articles?author={$author->id}")
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'text',
                        'article_photo_path',
                        'announcement',
                        'slug',
                        'author' => [
                            'id',
                            'name',
                            'email',
                            'biography',
                            'slug'
                        ]
                    ]
                ]
            ])
            ->assertJsonFragment([
                'id' => $article->id
            ])
            ->assertJsonFragment([
                'id' => $author->id
            ])
            ->assertOk();
    }
}
