<?php

namespace Tests;

use App\Enums\Roles;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return int
     * @throws Exception
     */
    protected function actingAsAdmin(): int
    {
        $user = User::factory()->create(['role' => Roles::ADMIN]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::ADMIN)
        );
        return $user->id;
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function actingAsAuthor(): int
    {
        $user = User::factory()->create(['role' => Roles::AUTHOR]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::AUTHOR)
        );
        return $user->id;
    }

    /**
     * @return int
     * @throws Exception
     */
    protected function actingAsOther(): int
    {
        $user = User::factory()->create(['role' => Roles::OTHER]);
        Sanctum::actingAs(
            $user,
            Roles::getAbilities(Roles::OTHER)
        );
        return $user->id;
    }

    /**
     * @param string $rule
     * @param string $url
     * @param array $body
     * @param string $attribute
     * @param array $replaces
     * @param string $method
     * @return void
     * @throws Exception
     */
    protected function validationTest(
        string $rule,
        string $url,
        array $body,
        string $attribute,
        array $replaces = [],
        string $method = 'post',
    ): void {
        $request = match ($method) {
            'get' => $this->getJson($url, $body),
            'put' => $this->putJson($url, $body),
            'post' => $this->postJson($url, $body),
            default => throw new Exception('Не поддерживаемый метод запроса'),
        };

        $replaces = array_merge(['attribute' => $attribute], $replaces);

        $request->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    $attribute => [__('validation.' . $rule, $replaces)]
                ]
            ]);
    }


}
