<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testRegistration(): void
    {
        $response = $this->postJson(
            'api/auth/registration',
            [
                'email' => 'test@test.com',
                'password' => 'password',
                'name' => 'Test'
            ]
        );

        $response
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testLogin(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/auth/login', ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(200);

        $this->getJson('api/auth/me', ['Authorization' => 'Bearer ' . $response->json('access_token')])
            ->assertJsonFragment(['id' => $user->id])
            ->assertOk();

        $this->assertAuthenticatedAs($user, 'sanctum');

    }

    /**
     * @return void
     */
    public function testMe(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('api/auth/me');

        $response
            ->assertJsonFragment(['id' => $user->id])
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testLogout(): void
    {
        // У sanctum нет встроенной функции logout, поэтому проверятся удаление токена
        // todo оставить только logout
        $user = User::factory()->create();

        $response = $this
            ->post('api/auth/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk();

        $this->getJson('api/auth/me', ['Authorization' => 'Bearer ' . $response->json('access_token')])
            ->assertJsonFragment(['id' => $user->id])
            ->assertOk();

        $tokens = PersonalAccessToken::where(['tokenable_id' => $user->id, 'name' => 'auth_token'])->first();

        $this->assertEquals(
            $tokens->tokenable_id,
            $user->id,
            'После аутентификации токен отсутствует'
        );

        $this->assertAuthenticatedAs($user, 'sanctum');

        $this
            ->post('api/auth/logout', [], ['Authorization' => 'Bearer ' . $response->json('access_token')])
            ->assertOk();

//        $this->refreshApplication();

//        $this->getJson('api/auth/me', ['Authorization' => 'Bearer ' . $response->json('access_token')])
//            ->assertUnauthorized();

        $tokens = PersonalAccessToken::where(['tokenable_id' => $user->id, 'name' => 'auth_token'])->first();

        $this->assertEmpty(
            $tokens,
            'Существует токен аутентификации у пользователя после logout'
        );

//        $this->assertGuest('sanctum');
    }

}
