<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserCanNotVerifiedException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.user_can_not_verified', Response::HTTP_BAD_REQUEST);
    }
}
