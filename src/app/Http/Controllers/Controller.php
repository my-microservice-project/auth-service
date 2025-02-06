<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Auth Service",
 *     version="1.0.0",
 *     description="Auth API Documentation",
 *     @OA\Contact(
 *         email="bugrabozkurtt@gmail.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */
abstract class Controller
{
    use ResponseTrait;
    //
}
