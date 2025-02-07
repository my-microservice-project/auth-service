<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Exceptions\UserCanNotLogoutException;
use BugraBozkurt\InterServiceCommunication\Helpers\AuthHelper;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutService
{

    /**
     * @throws UserCanNotLogoutException
     */
    public function logout(): bool
    {
        try {
            $token = $this->getUserToken();

            if (!$token) {
                return false;
            }

            $this->setTokenToBlacklist($token);
            $this->forgetCacheKey($this->getCacheKey());

            return true;
        } catch (\Exception $e) {
            throw new UserCanNotLogoutException();
        }
    }

    private function getUserToken(): ?string
    {
        return JWTAuth::getToken();
    }

    private function getCacheKey(): string
    {
        return CacheEnum::JWT->getValue() . AuthHelper::customerId();
    }

    private function setTokenToBlacklist(string $token): void
    {
        Cache::set(CacheEnum::BLACK_LIST->getValue().$token, true, CacheEnum::BLACK_LIST->getTTL());
    }

    private function forgetCacheKey(string $cacheKey): void
    {
        Cache::forget($cacheKey);
    }

}
