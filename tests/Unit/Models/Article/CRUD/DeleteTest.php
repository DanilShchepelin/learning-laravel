<?php

namespace Tests\Unit\Models\Article\CRUD;

use App\Models\Article;
use App\Models\User;
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
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->delete();

        $this->assertFalse($article->exists, 'Статья все еще существует');
    }
}
