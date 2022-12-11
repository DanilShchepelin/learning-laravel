<?php

namespace Feature\Models\Article;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleIsCreate(): void
    {
        $article = Article::factory()->create(['author_id' => 1]);

        $this->assertTrue($article->exists);
    }
}
