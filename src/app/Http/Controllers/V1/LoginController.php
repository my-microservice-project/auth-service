<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\UserCanNotVerifiedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Managers\LoginManager;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Authentication',
    description: 'User authentication related operations'
)]
class LoginController extends Controller
{
    public function __construct(
        protected LoginManager $loginManager
    ) {}

    /**
     * @throws UserCanNotVerifiedException
     */
    #[OA\Post(
        path: '/api/v1/login',
        description: 'Authenticates a user and returns a JWT token',
        summary: 'User login',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'turker.jonturk@example.com'
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        format: 'password',
                        example: '123456789'
                    ),
                ]
            )
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successful login',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'status',
                            type: 'string',
                            example: 'Success'
                        ),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(
                                    property: 'userId',
                                    type: 'integer',
                                    example: 1
                                ),
                                new OA\Property(
                                    property: 'token',
                                    type: 'string',
                                    example: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'
                                ),
                                new OA\Property(
                                    property: 'ttl',
                                    type: 'integer',
                                    example: 3600
                                ),
                            ],
                            type: 'object'
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized - Invalid credentials',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'User cannot be verified.'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'The given data was invalid.'
                        ),
                        new OA\Property(
                            property: 'errors',
                            properties: [
                                new OA\Property(
                                    property: 'email',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'string',
                                        example: 'The email field is required.'
                                    )
                                ),
                                new OA\Property(
                                    property: 'password',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'string',
                                        example: 'The password field is required.'
                                    )
                                ),
                            ],
                            type: 'object'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function login(LoginRequest $request): LoginResource
    {
        $login = $this->loginManager->handle($request->payload());
        return (new LoginResource($login))
            ->additional(['status' => 'Success']);
    }
}
