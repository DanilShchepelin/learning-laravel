<?php

namespace Tests\Feature\Controllers\Auth\Validation;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
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
}
