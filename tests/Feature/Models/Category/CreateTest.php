<?php

namespace Tests\Feature\Models\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCategoryIsCreated(): void
    {
        $category = Category::factory()->create();

        $this->assertTrue($category->exists());
    }
}
