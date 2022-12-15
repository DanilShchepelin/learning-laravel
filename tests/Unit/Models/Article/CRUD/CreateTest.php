<?php

namespace Tests\Unit\Models\Article\CRUD;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleIsCreate(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this->assertTrue($article->exists, 'Статья не создалась');
    }
}
