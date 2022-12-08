<?php

namespace App\Enums;

use Exception;

enum Roles
{
    case Admin;
    case Author;
    case Other;

    /**
     * @param string $role
     * @return array
     * @throws Exception
     */
    public static function getAbilities(string $role): array
    {
        $role = self::create($role);

        return match ($role->name) {
            self::Admin->name => ['*'],
            self::Other->name => [],
            self::Author->name => [
                'article:create'
            ],
            default => throw new Exception('Не поддерживаемая роль'),
        };
    }

    public function getName(): string
    {
        return $this->name;
    }

    private static function create(string $string): self
    {
        return constant(self::class . "::{$string}");
    }
}
