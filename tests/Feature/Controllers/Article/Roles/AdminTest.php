<?php

namespace Tests\Feature\Controllers\Article\Roles;

use App\Enums\Roles;
use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
// todo Проверить почему не работает подвязка автора
    /**
     * @return void
     * @throws Exception
     */
    public function testStore(): void
    {
        User::factory(4)->create();
        $user_id = $this->actingAsAdmin();
        $article = [
            'title' => $this->faker->title,
            'text' => $this->faker->text
        ];

        $response = $this
            ->post('/api/articles', $article)
            ->assertStatus(201);

        $this->assertEquals($user_id, $response['article']['author_id']);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testUpdate(): void
    {
        $user_id = $this->actingAsAdmin();
        $article = Article::factory()->create(['author_id' => $user_id]);

        $response = $this->postJson("/api/articles/{$article->id}", ['title' => 'Hello2']);

        $response
            ->assertJsonFragment(['title' => 'Hello2'])
            ->assertStatus(200);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testDestroy(): void
    {
        $user_id = $this->actingAsAdmin();

        $article = Article::factory()->create(['author_id' => $user_id]);

        $response = $this->delete("/api/articles/{$article->id}");

        $response->assertStatus(204);
    }
}
