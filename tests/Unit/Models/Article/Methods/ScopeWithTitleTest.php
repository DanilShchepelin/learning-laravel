<?php

namespace Tests\Unit\Models\Article\Methods;

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

        $found_article = Article::query()->withTitle($article->title)->first();

        $this->assertEquals($article->title, $found_article->title);
    }
}
