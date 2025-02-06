<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserCanNotLogoutException;
use App\Http\Controllers\Controller;
use App\Services\LogoutService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication related operations"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your Bearer Token in the format: 'Bearer {token}'"
 * )
 */
class LogoutController extends Controller
{
    public function __construct(
        protected LogoutService $logoutService
    ){}

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="User logout",
     *     description="Logs out the authenticated user by invalidating their JWT token.",
     *     tags={"Authentication"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Success"),
     *             @OA\Property(property="message", type="string", example="User logged out successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User is not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User cannot be logged out.")
     *         )
     *     )
     * )
     *
     * @throws UserCanNotLogoutException
     */
    public function logout(): JsonResponse
    {
        $this->logoutService->logout();
        return $this->successResponse();
    }
}
