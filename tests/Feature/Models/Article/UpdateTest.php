<?php

namespace Feature\Models\Article;

use App\Models\Article;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleIsUpdate(): void
    {
        $article = Article::factory()->create(['author_id' => 1]);

        $article->update(['title' => 'Test']);

        $this->assertEquals('Test', $article->title, 'Заголовок не поменялся');
    }
}
