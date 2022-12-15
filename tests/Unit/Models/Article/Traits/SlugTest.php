<?php

namespace Tests\Unit\Models\Article\Traits;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testSlugIsDifferent(): void
    {
        $user = User::factory()->create();
        $articles = Article::factory(2)->create(['title' => 'Test', 'author_id' => $user->id]);

        $this->assertEquals('test', $articles[0]->slug);
        $this->assertEquals('test-2', $articles[1]->slug);
    }
}
