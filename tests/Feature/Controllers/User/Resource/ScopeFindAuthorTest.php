<?php

namespace Tests\Feature\Controllers\User\Resource;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScopeFindAuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testScopeFindAuthor(): void
    {
        $user = User::factory()->create();

        $this
            ->get("api/users?name={$user->name}")
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'biography',
                        'slug'
                    ]
                ]
            ])
            ->assertJsonFragment([
                'id' => $user->id
            ])
            ->assertOk();
    }
}
