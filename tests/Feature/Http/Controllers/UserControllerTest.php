<?php

namespace Feature\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndex(): void
    {
        User::factory(10)->create();

        $response = $this->get('/api/users');

        $response
            ->assertJsonStructure([
                'data' => [
                    '*' =>  [
                        'id',
                        'name',
                        'email',
                        'biography',
                        'slug'
                    ]
                ]
            ])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testChangePassword(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $response = $this
            ->actingAs($user, 'sanctum')
            ->put("/api/users/{$user->id}/reset-password", ['current_password' => 'password', 'password' => 'Passw0rd']);

        $response
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShow(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/{$user->slug}");

        $response
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'biography',
                    'slug'
                ]
            ])
            ->assertJsonCount(1)
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['name' => 'Ivan']);

        $response = $this->actingAs($user, 'sanctum')->post("/api/users/{$user->id}", ['name' => "Danil"]);

        $response
            ->assertJsonFragment(['name' => 'Danil'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create(['role' => Roles::Admin->getName()]);

        $response = $this->actingAs($user, 'sanctum')->delete("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->expectException(ModelNotFoundException::class);
        User::query()->findOrFail($user->id);
    }
}
