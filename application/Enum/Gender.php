<?php

declare(strict_types=1);

namespace App\Enum;

enum Gender: int
{
    case Male = 1;
    case Female = 0;

    public static function search(?string $sex): int|null
    {
        return match ($sex) {
            'male' => self::Male->value,
            'female' => self::Female->value,
            default => null,
        };
    }
}
