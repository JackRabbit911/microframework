<?php

declare(strict_types=1);

namespace App\DTO;

class User
{
    public static function fromObject(object $user)
    {
        return new self($user->id, $user->name);
    }

    public static function fromArray(array $user)
    {
        return new self($user['id'], $user['name']);
    }

    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ){}
}
