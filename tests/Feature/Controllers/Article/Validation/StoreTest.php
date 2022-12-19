<?php

namespace Tests\Feature\Controllers\Article\Validation;

use App\Enums\Roles;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
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
        $this->actingAsAuthor();

        $article = [
            'title' => $this->faker->title,
            'text' => $this->faker->text
        ];

        $this
            ->postJson('/api/articles', $article)
            ->assertStatus(201);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldText(): void
    {
        $this->actingAsAuthor();
        $this->validationTest(
            'required',
            '/api/articles',
            ['title' => $this->faker->title],
            'text'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldTitle(): void
    {
        $this->actingAsAuthor();
        $this->validationTest(
            'required',
            '/api/articles',
            ['text' => $this->faker->text],
            'title'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldTitle(): void
    {
        $this->actingAsAuthor();
        $this->validationTest(
            'max.string',
            '/api/articles',
            [
                'title' => $this->faker->realTextBetween(256, 270),
                'text' => $this->faker->text
            ],
            'title',
            ['max' => 255]
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldText(): void
    {
        $this->actingAsAuthor();
        $this->validationTest(
            'max.string',
            '/api/articles',
            [
                'title' => $this->faker->title,
                'text' => $this->faker->realTextBetween(65536, 65700)
            ],
            'text',
            ['max' => 65535]
        );
    }
}
