<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->registerUser($request->validated());

        return response()->json(new UserResource($user), 201);
    }
    
}