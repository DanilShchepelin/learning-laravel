<?php

namespace Tests\Unit\Models\User\Methods;

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

        $found_user = User::query()->findAuthor($user->name)->first();

        $this->assertEquals($user->name, $found_user->name);
    }
}
