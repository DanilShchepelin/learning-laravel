<?php

namespace Tests;

use App\Enums\Roles;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Util\Exception as UnitException;

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
     * @param string $rule
     * @param string $url
     * @param array $body
     * @param string $attribute
     * @param array $replaces
     * @param string $method
     * @return void
     */
    protected function validationTest(
        string $rule,
        string $url,
        array $body,
        string $attribute,
        array $replaces = [],
        string $method = 'post',
    ): void {
        if ($method !== 'post') {
            throw new UnitException('Param $method not implemented');
        }

        $replaces = array_merge(['attribute' => $attribute], $replaces);

        $request = $this->postJson($url, $body);
        $request->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    $attribute => [__('validation.' . $rule, $replaces)]
                ]
            ]);
    }


}
