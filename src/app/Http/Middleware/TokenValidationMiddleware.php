<?php

namespace App\Http\Middleware;

use App\Exceptions\UserCanNotLogoutException;
use App\Traits\ResponseTrait;
use BugraBozkurt\InterServiceCommunication\Helpers\AuthHelper;
use Closure;
use Symfony\Component\HttpFoundation\Response;

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
                return $this->errorResponse('Unauthorized', [],Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            throw new UserCanNotLogoutException();
        }

        return $next($request);
    }

}
