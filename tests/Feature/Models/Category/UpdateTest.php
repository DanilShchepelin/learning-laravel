<?php

namespace Feature\Models\Category;

use App\Models\Category;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * @return void
     */
    public function testCategoryIsUpdate(): void
    {
        $category = Category::factory()->create();

        $category->update(['title' => 'Test']);

        $this->assertTrue($category->exists);
        $this->assertEquals('Test', $category->title, 'Данные не совпадают');
    }
}
