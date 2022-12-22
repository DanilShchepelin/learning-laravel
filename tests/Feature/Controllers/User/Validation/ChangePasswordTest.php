<?php

namespace Tests\Feature\Controllers\User\Validation;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     * @throws Exception
     */
    public function testIsValid(): void
    {
        $user_id = $this->actingAsAuthor();

        $data = [
            'current_password' => 'password',
            'password' => $this->faker->password(3, 255)
        ];

        $this
            ->putJson("api/users/{$user_id}/reset-password", $data)
            ->assertOk();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldCurrentPassword(): void
    {
        $user_id = $this->actingAsAdmin();
        $this->validationTest(
            'required',
            "/api/users/{$user_id}/reset-password",
            ['password' => 'password'],
            'current_password',
            ['attribute' => 'current password'],
            'put'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testIsCurrentPassword(): void
    {
        $user_id = $this->actingAsAdmin();
        $data = [
            'current_password' => 'passw0rd',
            'password' => $this->faker->password(3, 255)
        ];
        $this
            ->putJson("/api/users/{$user_id}/reset-password", $data)
            ->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'current_password' => ['The provided password does not match your current password.']
                ]
            ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testRequiredFieldPassword(): void
    {
        $user_id = $this->actingAsAdmin();
        $this->validationTest(
            'required',
            "/api/users/{$user_id}/reset-password",
            ['current_password' => 'password'],
            'password',
            [],
            'put'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMaxFieldPassword(): void
    {
        $user_id = $this->actingAsAdmin();
        $this->validationTest(
            'max.string',
            "/api/users/{$user_id}/reset-password",
            [
                'current_password' => 'password',
                'password' => $this->faker->password(256, 260)
            ],
            'password',
            ['max' => 255],
            'put'
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testMinFieldPassword(): void
    {
        $user_id = $this->actingAsAdmin();
        $this->validationTest(
            'min.string',
            "/api/users/{$user_id}/reset-password",
            [
                'current_password' => 'password',
                'password' => $this->faker->password(1, 2)
            ],
            'password',
            ['min' => 3],
            'put'
        );
    }
}
