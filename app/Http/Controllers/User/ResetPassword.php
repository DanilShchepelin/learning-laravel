<?php

namespace App\Http\Controllers\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Request;

class ResetPassword extends Controller
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param mixed $user
     * @param array $input
     * @param ChangePasswordRequest $request
     * @return void
     */
    public function __invoke(User $user, array $input, ChangePasswordRequest $request): void
    {
        // todo peredelat
//        Validator::make($input, [
//            'current_password' => ['required', 'string'],
//            'password' => $this->passwordRules(),
//        ])->after(function ($validator) use ($user, $input) {
//            if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
//                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
//            }
//        })->validateWithBag('updatePassword');
        $password = $request->validated('password');

        $user->forceFill([
            'password' => $input['password'],
        ])->save();
    }
}
