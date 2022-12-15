<?php

namespace Tests\Unit\Models\Article\CRUD;

use App\Models\Article;
use App\Models\User;
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
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->update(['title' => 'Test']);

        $this->assertEquals('Test', $article->title, 'Заголовок не поменялся');
    }
}
