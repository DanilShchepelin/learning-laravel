<?php

namespace Tests\Feature\Controllers\Category\Roles;

use App\Enums\Roles;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAdminStore(): void
    {
        $this->actingAsAdmin();

        $category = Category::factory()->make();

        $response = $this->post('/api/categories', $category->toArray());

        $response->assertStatus(201);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAdminUpdate(): void
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $response = $this->post("/api/categories/{$category->id}", ['title' => 'hello2']);

        $response
            ->assertJsonFragment(['title' => 'hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCanAdminDestroy(): void
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(204);

        $this->assertModelMissing($category);
    }
}
