<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class JWTToken extends Data
{
    public function __construct(
        public int $userId,
        public int $ttl,
        public string $token
    )
    {}
}
