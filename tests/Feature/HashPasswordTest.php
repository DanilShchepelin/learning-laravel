<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HashPasswordTest extends TestCase
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
