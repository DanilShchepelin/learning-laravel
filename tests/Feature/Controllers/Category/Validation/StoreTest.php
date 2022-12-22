<?php

namespace Tests\Feature\Controllers\Category\Validation;

use App\Models\Category;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     * @throws Exception
     */
    public function testIsValid(): void
    {
        $this->actingAsAdmin();

        $category = [
            'title' => $this->faker->title,
            'description' => $this->faker->text
        ];

        $this
            ->postJson('/api/categories', $category)
            ->assertStatus(201);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldTitle(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'required',
            '/api/categories',
            ['description' => $this->faker->text],
            'title'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldTitle(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'max.string',
            '/api/categories',
            [
                'title' => $this->faker->realTextBetween(256, 270),
                'description' => $this->faker->text
            ],
            'title',
            ['max' => 255]
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldDescription(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'required',
            '/api/categories',
            ['title' => $this->faker->title],
            'description'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldDescription(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'max.string',
            '/api/categories',
            [
                'title' => $this->faker->title,
                'description' => $this->faker->realTextBetween(65536, 65700)
            ],
            'description',
            ['max' => 65535]
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testParentIdCantBeNonExist(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'exists',
            '/api/categories',
            [
                'title' => $this->faker->title,
                'description' => $this->faker->text,
                'parent_id' => 999
            ],
            'parent_id',
            ['attribute' => 'parent id']
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testParentIdMustBeInteger(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'integer',
            '/api/categories',
            [
                'title' => $this->faker->title,
                'description' => $this->faker->text,
                'parent_id' => 'Isn`t integer',
            ],
            'parent_id',
            ['attribute' => 'parent id']
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testParentIdCanBeNull(): void
    {
        $this->actingAsAdmin();
        $category = [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'parent_id' => null
        ];

        $this
            ->postJson('/api/categories', $category)
            ->assertStatus(201);

        $category_new = Category::where('title', $category['title'])
            ->where('description', $category['description'])
            ->first();

        $this->assertEquals(null, $category_new->parent_id);
    }
}
