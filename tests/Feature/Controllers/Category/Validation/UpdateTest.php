<?php

namespace Tests\Feature\Controllers\Category\Validation;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function testIsValid(): void
    {
        $parent = Category::factory()->create();
        $category = Category::factory()->create();
        $this->actingAsAdmin();

        $newData = [
            'title' => 'Test',
            'description' => 'Test description',
            'parent_id' => $parent->id
        ];

        $this
            ->postJson("/api/categories/{$category->id}", $newData)
            ->assertStatus(200);

        $category->refresh();

        $this->assertEquals('Test', $category->title);
        $this->assertEquals('Test description', $category->description);
        $this->assertEquals($parent->id, $category->parent_id);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testTitleCantBeNull(): void
    {
        $category = Category::factory()->create();
        $this->actingAsAdmin();

        $this
            ->postJson("/api/categories/{$category->id}", ['title' => null])
            ->assertStatus(422);

        $category->refresh();

        $this->assertNotEquals(null, $category->title);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testDescriptionCantBeNull(): void
    {
        $category = Category::factory()->create();
        $this->actingAsAdmin();

        $this
            ->postJson("/api/categories/{$category->id}", ['description' => null])
            ->assertStatus(422);

        $category->refresh();

        $this->assertNotEquals(null, $category->description);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testParentIdCantBeNonExist(): void
    {
        $category = Category::factory()->create();
        $this->actingAsAdmin();
        $this->validationTest(
            'exists',
            "/api/categories/{$category->id}",
            ['parent_id' => 999],
            'parent_id',
            ['attribute' => 'parent id']
        );

        $category->refresh();

        $this->assertNotEquals(999, $category->parent_id);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testParentIdCantBeString(): void
    {
        $category = Category::factory()->create();
        $this->actingAsAdmin();
        $this->validationTest(
            'integer',
            "/api/categories/{$category->id}",
            ['parent_id' => 'bla bla bla'],
            'parent_id',
            ['attribute' => 'parent id']
        );

        $category->refresh();

        $this->assertNotEquals(999, $category->parent_id);
    }
}
