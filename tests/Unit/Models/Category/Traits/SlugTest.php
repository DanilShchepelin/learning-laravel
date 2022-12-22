<?php

namespace Tests\Unit\Models\Category\Traits;

use App\Models\Category;
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
        $categories = Category::factory(2)->create(['title' => 'Test']);

        $this->assertNotEquals($categories[1]->slug, $categories[0]->slug);
    }
}
