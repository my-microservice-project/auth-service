<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserCanNotLogoutException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.user_can_not_logout', Response::HTTP_BAD_REQUEST);
    }
}
