<?php

namespace Tests\Feature\Controllers\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ControllerTest extends TestCase
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
    public function testChangePassword(): void
    {
        $user = User::factory()->create(['password' => 'password']);
        Sanctum::actingAs($user);

        $response = $this
            ->put("/api/users/{$user->id}/reset-password", ['current_password' => 'password', 'password' => 'Passw0rd']);

        $response
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create(['name' => 'Ivan']);
        Sanctum::actingAs($user);

        $response = $this->post("/api/users/{$user->id}", ['name' => "Danil"]);

        $response
            ->assertJsonFragment(['name' => 'Danil'])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testCantUpdateOther(): void
    {
        $user = User::factory()->create(['name' => 'Ivan']);
        $other = User::factory()->create();
        Sanctum::actingAs($user);

        $this
            ->post("/api/users/{$other->id}", ['name' => "Danil"])
            ->assertStatus(403);

        $other->fresh();
        $this->assertNotEquals('Danil', $other->name);
    }

    /**
     * @return void
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->delete("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertModelMissing($user);
    }

    /**
     * @return void
     */
    public function testCantDestroyOther(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->delete("/api/users/{$other->id}");

        $response->assertStatus(403);

        $this->assertModelExists($other);
    }
}
