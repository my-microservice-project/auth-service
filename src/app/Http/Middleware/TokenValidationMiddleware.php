<?php

namespace App\Http\Middleware;

use App\Exceptions\UserCanNotLogoutException;
use App\Exceptions\UserNotFoundException;
use App\Traits\ResponseTrait;
use BugraBozkurt\InterServiceCommunication\Helpers\AuthHelper;
use Closure;

class TokenValidationMiddleware
{
    use ResponseTrait;

    /**
     * @throws UserCanNotLogoutException
     */
    public function handle($request, Closure $next)
    {
        try {
            if(!AuthHelper::customerId()){
                throw new UserNotFoundException();
            }
        } catch (\Exception $e) {
            throw new UserCanNotLogoutException();
        }

        return $next($request);
    }

}
