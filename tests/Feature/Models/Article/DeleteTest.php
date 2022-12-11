<?php

namespace Feature\Models\Article;

use App\Models\Article;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleIsDelete(): void
    {
        $article = Article::factory()->create(['author_id' => 1]);

        $article->delete();

        $this->assertFalse($article->exists);
    }
}
