<?php

namespace Tests\Unit\Models\User\CRUD;

use App\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsCreate(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->exists, 'Пользователь не создан');
    }
}
