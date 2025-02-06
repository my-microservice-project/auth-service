<?php

namespace App\Enums;

enum CacheEnum: string
{
    case JWT = 'jwt:';

    case BLACK_LIST = 'blacklist:';

    public function getValue(): string
    {
        return $this->value;
    }

    public function getTTL(): int
    {
        return match ($this) {
            self::JWT, self::BLACK_LIST => 3600,
        };
    }
}
