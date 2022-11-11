<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Registration extends \App\Http\Controllers\Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $user = (new User)->create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            UserResource::make($user),
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
