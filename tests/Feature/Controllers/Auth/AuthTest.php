<?php

namespace Tests\Feature\Controllers\Auth;

use App\Enums\Roles;
use App\Enums\TokensTypes;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
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
        Sanctum::actingAs($user);

        $response = $this->getJson('api/auth/me');

        $response
            ->assertJsonFragment(['id' => $user->id])
            ->assertStatus(200);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testLogout(): void
    {

        $user = User::factory()->create();
        $token = $user->createToken(TokensTypes::AUTH_TOKEN, Roles::getAbilities($user->role));
        $exist_token = PersonalAccessToken::where(['tokenable_id' => $user->id, 'name' => TokensTypes::AUTH_TOKEN])->first();

        $this->assertEquals($exist_token->id, $token->accessToken->id);
        $this->assertEquals(
            $exist_token->tokenable_id,
            $user->id,
            'После аутентификации токен отсутствует'
        );

        $this
            ->post('api/auth/logout', [], ['Authorization' => 'Bearer ' . $token->plainTextToken])
            ->assertOk();

        $tokens = PersonalAccessToken::where(['tokenable_id' => $user->id, 'name' => TokensTypes::AUTH_TOKEN])->first();
        $this->assertEmpty(
            $tokens,
            'Существует токен аутентификации у пользователя после logout'
        );
    }

}
