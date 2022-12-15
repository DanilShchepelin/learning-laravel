<?php

namespace Tests\Feature\Controllers\Category\Validation;

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
            'title' => 'Test',
            'description' => 'Test description'
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
            ['description' => 'Test description'],
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
                'description' => 'Test description'
            ],
            'title',
            ['max' => 255]
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
                'title' => 'Title',
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
    public function testRequiredFieldDescription(): void
    {
        $this->actingAsAdmin();
        $this->validationTest(
            'required',
            '/api/categories',
            ['title' => 'Test'],
            'description'
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
                'title' => 'Test',
                'description' => 'Test description',
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
                'title' => 'Test',
                'description' => 'Test description',
                'parent_id' => 'Isn`t integer',
            ],
            'parent_id',
            ['attribute' => 'parent id']
        );
    }
}
