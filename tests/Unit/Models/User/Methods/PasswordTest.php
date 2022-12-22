<?php

namespace Tests\Unit\Models\User\Methods;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
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
