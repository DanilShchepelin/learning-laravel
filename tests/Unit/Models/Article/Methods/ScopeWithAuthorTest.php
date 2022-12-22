<?php

namespace Tests\Unit\Models\Article\Methods;

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
    public function testScopeWithAuthorSlug(): void
    {
        $author = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $author->id]);

        $found = Article::query()->withAuthor($author->slug)->first();
        $this->assertNotEmpty($found);

        $this->assertEquals($found->id, $article->id);
        $this->assertEquals($found->author_id, $author->id);
    }

    /**
     * @return void
     */
    public function testScopeWithAuthorId(): void
    {
        $author = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $author->id]);

        $found = Article::query()->withAuthor($author->id)->first();
        $this->assertNotEmpty($found);

        $this->assertEquals($found->id, $article->id);
        $this->assertEquals($found->author_id, $author->id);
    }
}
