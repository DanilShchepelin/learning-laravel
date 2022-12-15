<?php

namespace Tests\Unit\Models\User\CRUD;

use App\Models\User;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsUpdate(): void
    {
        $user = User::factory()->create(['name' => 'Test']);

        $user->update(['name' => 'Test2']);

        $this->assertTrue($user->exists, 'Пользователь не создан');
        $this->assertEquals('Test2', $user->name, 'Имя не совпадает');
    }
}
