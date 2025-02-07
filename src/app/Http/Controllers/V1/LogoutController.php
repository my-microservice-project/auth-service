<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserCanNotLogoutException;
use App\Http\Controllers\Controller;
use App\Services\LogoutService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Authentication",
    description: "User authentication related operations"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Enter your Bearer Token in the format: 'Bearer {token}'",
    bearerFormat: "JWT",
    scheme: "bearer"
)]
class LogoutController extends Controller
{
    public function __construct(
        protected LogoutService $logoutService
    ) {}

    /**
     * @throws UserCanNotLogoutException
     */
    #[OA\Post(
        path: "/api/v1/logout",
        operationId: null,
        description: "Logs out the authenticated user by invalidating their JWT token.",
        summary: "User logout",
        security: [["bearerAuth" => []]],
        servers: null,
        requestBody: null,
        tags: ["Authentication"],
        parameters: null,
        responses: [
            new OA\Response(
                response: 200,
                description: "Successfully logged out",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "status",
                            type: "string",
                            example: "Success"
                        ),
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "User logged out successfully."
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized - User is not authenticated",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "Unauthenticated."
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 500,
                description: "Internal server error",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "User cannot be logged out."
                        )
                    ]
                )
            )
        ],
        externalDocs: null,
        deprecated: false
    )]
    public function logout(): JsonResponse
    {
        $this->logoutService->logout();
        return $this->successResponse();
    }
}
