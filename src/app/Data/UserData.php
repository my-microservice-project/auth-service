<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $last_name,
        public string $email,
    ) {}
}
