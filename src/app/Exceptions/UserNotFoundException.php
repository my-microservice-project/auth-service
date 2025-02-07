<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends BaseException
{
    public function __construct()
    {
        parent::__construct('messages.user_not_found', Response::HTTP_BAD_REQUEST);
    }
}
