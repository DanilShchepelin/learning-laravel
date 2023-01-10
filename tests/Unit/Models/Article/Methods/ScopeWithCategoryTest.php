<?php

namespace Tests\Unit\Models\Article\Methods;

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
    public function testScopeWithCategorySlug(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->categories()->attach($category->id);

        $found_article = Article::query()->withCategory($category->slug)->first();

        foreach ($found_article->categories as $categories) {
            $found_category_id = $categories->pivot->category_id;
        }

        $this->assertNotEmpty($found_category_id);
        $this->assertNotEmpty($found_article);
        $this->assertEquals($found_article->id, $article->id);
        $this->assertEquals($found_category_id, $category->id);
    }

    /**
     * @return void
     */
    public function testScopeWithCategoryId(): void
    {
        $category = Category::factory()->create();
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $article->categories()->attach($category->id);

        $found_article = Article::query()->withCategory($category->id)->first();

        foreach ($found_article->categories as $categories) {
            $found_category_id = $categories->pivot->category_id;
        }

        $this->assertEquals($found_article->id, $article->id);
        $this->assertEquals($found_category_id, $category->id);
    }
}
