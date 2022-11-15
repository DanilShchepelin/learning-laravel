<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->firstOrFail();

        if (Hash::check($request->validated('password'), $user->password) === false) {
            return response()->json([
                'message' => 'Invalid login or password'
            ]);
        }

        /** @var User $current_user */
        $current_user = auth('sanctum')->user();
        if ($current_user !== null && $current_user->tokens()->exists()) {
            $current_user->tokens()->delete();
        }

        if ($user->tokens()->exists()) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('auth_token', Roles::getAbilities($user->role));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }
}