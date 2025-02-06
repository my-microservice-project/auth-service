<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserCanNotVerifiedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Managers\LoginManager;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication related operations"
 * )
 */
class LoginController extends Controller
{
    public function __construct(
        protected LoginManager $loginManager
    ) {}

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User login",
     *     description="Authenticates a user and returns a JWT token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="userId", type="integer", example=1),
     *                 @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *                 @OA\Property(property="ttl", type="integer", example=3600)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User cannot be verified.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="The password field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @throws UserCanNotVerifiedException
     */
    public function login(LoginRequest $request): LoginResource
    {
        $login = $this->loginManager->handle($request->payload());
        return (new LoginResource($login))
            ->additional(['status' => 'Success']);
    }
}
