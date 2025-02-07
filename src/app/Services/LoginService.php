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
        $cacheKey = $this->buildCacheKey($user->id);
        $cachedToken = Cache::get($cacheKey);

        if ($this->isValidCachedToken($cachedToken)) {
            return $cachedToken;
        }

        $token = $this->createTokenForUser($user);

        Cache::put($cacheKey, $token, CacheEnum::JWT->getTTL());

        return $token;
    }


    private function isValidCachedToken($token): bool
    {
        return is_string($token) && !$this->isTokenExpired($token);
    }


    private function createTokenForUser(UserData $user): string
    {
        $jwtUser = new JWTUser($user->id);
        return JWTAuth::fromUser($jwtUser);
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

    private function buildCacheKey(int $userId): string
    {
        return CacheEnum::JWT->getValue() . $userId;
    }
}
