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

        $this->assertEquals('test', $categories[0]->slug);
        $this->assertEquals('test-2', $categories[1]->slug);
    }
}
