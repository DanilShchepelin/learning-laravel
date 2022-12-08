<?php

namespace Tests\Feature\Models\Article;

use App\Models\Article;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * @return void
     */
    public function testArticleIsCreated(): void
    {
        $article = Article::factory()->create();

        $this->assertTrue($article->exists());
    }
}
