<?php

namespace App\Managers;

use App\Data\JWTToken;
use App\Data\LoginData;
use App\Data\UserData;
use App\Enums\CacheEnum;
use App\Exceptions\UserCanNotVerifiedException;
use App\HttpRequests\AuthHttpRequests;
use App\Services\LoginService;

class LoginManager
{

    private false|UserData $user;

    public function __construct(
        protected LoginService $loginService,
        protected AuthHttpRequests $authHttpRequests
    )
    {}

    /**
     * @throws UserCanNotVerifiedException
     */
    public function handle(LoginData $loginData): JWTToken
    {
        $this->getUserByCredentials($loginData);

        if (!$this->user) {
            throw new UserCanNotVerifiedException();
        }

        $token = $this->loginService->generateToken($this->user);

        return new JWTToken(
            userId: $this->user->id,
            ttl: CacheEnum::JWT->getTTL(),
            token: $token
        );
    }

    public function getUserByCredentials(LoginData $loginData): void
    {
        $this->user = $this->authHttpRequests->verifyCredentials($loginData);
    }
}
