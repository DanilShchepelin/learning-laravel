<?php

namespace Tests\Unit\Models\User\Methods;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HashPasswordTest extends TestCase // todo назвать чтобы было понятно какой метод тестируется
{
    /**
     * @return void
     */
    public function testPasswordIsHashed(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $this->assertTrue($user->password !== 'password');
        $this->assertTrue(Hash::check('password', $user->password));
    }
}
