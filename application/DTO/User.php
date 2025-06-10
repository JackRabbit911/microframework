<?php

declare(strict_types=1);

namespace App\DTO;

class User
{
    public static function fromObject(object $user)
    {
        return new self($user->id, $user->name, $user->password);
    }

    public static function fromArray(array $user)
    {
        return new self($user['id'], $user['name'], $user['password']);
    }

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        private string $password
    ){}

    public function password()
    {
        return $this->password;
    }
}
