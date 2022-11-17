<?php

namespace App\Http\Controllers\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ChangePassword extends Controller
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param mixed $user
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function __invoke(User $user, ChangePasswordRequest $request): JsonResponse
    {
        $user->forceFill([
            'password' => $request->validated('password'),
        ])->save();

        return response()->json([
            'message' => 'User updated successfully',
        ]);
    }
}
