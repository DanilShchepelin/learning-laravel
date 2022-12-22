<?php

namespace Tests\Feature\Controllers\Article\Resource;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScopeWithTitleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testScopeWithTitle(): void
    {
        $author = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $author->id]);

        $this
            ->get("api/articles?title={$article->title}")
            ->assertJsonStructure([
                'data' => [
                    '*' =>  [
                        'id',
                        'title',
                        'text',
                        'article_photo_path',
                        'announcement',
                        'slug',
                    ]
                ]
            ])
            ->assertJsonFragment([
                'title' => $article->title
            ])
            ->assertOk();
    }
}
