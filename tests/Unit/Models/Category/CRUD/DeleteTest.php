<?php

namespace Tests\Unit\Models\Category\CRUD;

use App\Models\Category;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCategoryIsDelete(): void
    {
        $category = Category::factory()->create();

        $category->delete();

        $this->assertFalse($category->exists);
    }
}
