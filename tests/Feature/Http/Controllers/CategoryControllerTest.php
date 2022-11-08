<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testIndex(): void
    {
        Category::factory(10)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShow(): void
    {
        $category = Category::factory()->create();
        $response = $this->get('/api/categories/' . $category->id);

        $response
            ->assertJsonCount(1)
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testStore(): void
    {
        $category = Category::factory()->make();

        $response = $this->post('/api/categories', $category->toArray());

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $category = Category::factory()->create(['title' => 'Hello']);

        $response = $this->putJson("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertJsonFragment(['title' => 'hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);
        Category::query()->findOrFail($category->id);
    }
}
