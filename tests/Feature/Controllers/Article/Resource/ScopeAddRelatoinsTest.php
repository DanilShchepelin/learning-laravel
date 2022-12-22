<?php

namespace Tests\Feature\Controllers\Article\Resource;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScopeAddRelatoinsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testWithAuthor(): void
    {
        $user = User::factory()->create();
        Article::factory()->create(['author_id' => $user->id]);

        $response = $this->get('api/articles?with[]=author');

        $response
            ->assertJsonStructure([
                'data' => [
                    '*' =>  [
                        'id',
                        'title',
                        'text',
                        'article_photo_path',
                        'announcement',
                        'slug',
                        'author' => [
                            'id',
                            'name',
                            'email',
                            'biography',
                            'slug'
                        ]
                    ]
                ]
            ])
            ->assertOk();
    }

    /**
     * @return void
     */
    public function testWithCategory(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->categories()->attach($category->id);

        $this
            ->get('api/articles?with[]=categories')
            ->assertJsonStructure([
                'data' => [
                    '*' =>  [
                        'id',
                        'title',
                        'text',
                        'article_photo_path',
                        'announcement',
                        'slug',
                        'categories' => [
                            '*' => [
                                'id',
                                'title',
                                'slug'
                            ]
                        ]
                    ]
                ]
            ])
            ->assertOk();
    }
}
