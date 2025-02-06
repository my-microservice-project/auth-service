<?php

namespace App\Data;

use Tymon\JWTAuth\Contracts\JWTSubject;

class JWTUser implements JWTSubject
{
    public function __construct(
        protected int $id
    ) {}

    public function getJWTIdentifier(): int
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
