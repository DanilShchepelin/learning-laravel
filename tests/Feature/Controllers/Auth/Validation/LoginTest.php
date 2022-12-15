<?php

namespace Tests\Feature\Controllers\Auth\Validation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testLoginIsValid(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $this
            ->postJson(
                '/api/auth/login',
                ['email' => 'test@test.com', 'password' => 'password']
            )
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testRequiredFieldEmail(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $this->validationTest(
            'required',
            '/api/auth/login',
            ['password' => 'password'],
            'email'
        );
    }

    /**
     * @return void
     */
    public function testRequiredFieldPassword(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $this->validationTest(
            'required',
            '/api/auth/login',
            ['email' => 'test@test.com'],
            'password'
        );
    }

    /**
     * @return void
     */
    public function testValidEmail(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $this->validationTest(
            'email',
            '/api/auth/login',
            [
                'email' => 'test',
                'password' => 'password'
            ],
            'email'
        );
    }
}
