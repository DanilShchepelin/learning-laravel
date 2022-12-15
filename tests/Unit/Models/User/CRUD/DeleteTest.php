<?php

namespace Tests\Unit\Models\User\CRUD;

use App\Models\User;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsDelete(): void
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertFalse($user->exists, 'Пользователь все еще существует');
    }
}
