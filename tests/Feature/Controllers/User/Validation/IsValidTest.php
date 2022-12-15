<?php

namespace Tests\Feature\Controllers\User\Validation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IsValidTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testUpdateIsValid(): void
    {
        $user = User::factory()->create([
            'name' => 'Test',
            'email' => 'test2@test.com',
            'biography' => 'Big biography'
        ]);
        Sanctum::actingAs($user);

        $this
            ->postJson("/api/users/{$user->id}", ['email' => 'test3@test.com', 'name' => 'Test2', 'biography' => 'Small'])
            ->assertStatus(200);

    }
}
