<?php

namespace Tests\Feature\Controllers\Auth\Validation;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     */
    public function testRequiredFieldName(): void
    {
        $this->validationTest(
            'required',
            '/api/auth/registration',
            [
                'email' => 'test@gmail.com',
                'password' => 'password'
            ],
            'name'
        );
    }

    /**
     * @return void
     */
    public function testRequiredFieldEmail(): void
    {
        $this->validationTest(
            'required',
            '/api/auth/registration',
            [
                'name' => 'Test',
                'password' => 'password'
            ],
            'email'
        );
    }

    /**
     * @return void
     */
    public function testRequiredFieldPassword(): void
    {
        $this->validationTest(
            'required',
            '/api/auth/registration',
            [
                'name' => 'Test',
                'email' => 'test@gmail.com',
            ],
            'password'
        );
    }

    /**
     * @return void
     */
    public function testMaxFieldName(): void
    {
        $this->validationTest(
            'max.string',
            '/api/auth/registration',
            [
                'name' => $this->faker->realTextBetween(71, 80),
                'email' => 'test@gmail.com',
                'password' => 'password'
            ],
            'name',
            ['max' =>  70]
        );
    }

    /**
     * @return void
     */
    public function testUniqueFieldEmail(): void
    {
        User::factory()->create(['email' => 'test@gmail.com']);
        $this->validationTest(
            'unique',
            '/api/auth/registration',
            [
                'name' => $this->faker->name,
                'email' => 'test@gmail.com',
                'password' => 'password'
            ],
            'email'
        );
    }
}
