<?php

namespace App\Enums;

use Exception;

final class Roles
{
    public const ADMIN = 'admin';
    public const AUTHOR = 'author';
    public const OTHER = 'other';

    public const OPTIONS = [
        self::ADMIN,
        self::AUTHOR,
        self::OTHER,
    ];

    private function __construct()
    {
    }


    /**
     * @param string $role
     * @return array
     * @throws Exception
     */
    public static function getAbilities(string $role): array
    {
        if (self::isNotValid($role)) {
            throw new Exception('Не поддерживаемая роль');
        }

        return match ($role) {
            self::ADMIN => ['*'],
            self::AUTHOR => ['article:create'],
            self::OTHER => [],
        };
    }

    private static function isNotValid(string $role): bool
    {
        return !self::isValid($role);
    }

    private static function isValid(string $role): bool
    {
        return in_array($role, self::OPTIONS);
    }

}
