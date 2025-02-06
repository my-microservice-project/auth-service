<?php

namespace App\Services;

use App\Data\JWTUser;
use App\Data\UserData;
use App\Enums\CacheEnum;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService
{
    public function generateToken(UserData $user): string
    {
        $cacheKey = CacheEnum::JWT->getValue() . $user->id;
        $cachedToken = Cache::get($cacheKey);

        if ($cachedToken && is_string($cachedToken) && !$this->isTokenExpired($cachedToken)) {
            return $cachedToken;
        }

        $jwtUser = new JWTUser($user->id);
        $token = JWTAuth::fromUser($jwtUser);

        Cache::put($cacheKey, (string) $token, CacheEnum::JWT->getTtl());

        return $token;
    }

    private function isTokenExpired(string $token): bool
    {
        try {
            JWTAuth::setToken($token)->checkOrFail();
            return false;
        } catch (\Exception $e) {
            return true;
        }
    }
}
