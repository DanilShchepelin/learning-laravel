<?php

namespace App\Enums;

enum Roles
{
    case Admin;
    case Author;
    case Other;

    /**
     * @param string $role
     * @return array
     */
    public static function getAbilities(string $role): array
    {
        $role = self::create($role);

        return match ($role->name) {
            self::Admin->name => ['*'],
            self::Other->name => [],
            default => [$role->name],
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
