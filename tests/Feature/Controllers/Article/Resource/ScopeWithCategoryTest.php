<?php

namespace Tests\Feature\Controllers\Article\Resource;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScopeWithCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testScopeWithCategory(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->categories()->attach($category->id);

        $this
            ->get("api/articles?with[]=categories&category={$category->id}")
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
            ->assertJsonFragment([
                'id' => $article->id
            ])
            ->assertJsonFragment([
                'id' => $category->id
            ])
            ->assertOk();
    }
}
