<?php

namespace App\Http\Requests\User;

use App\Actions\Fortify\PasswordValidationRules;
use App\Rules\IsCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                new IsCurrentPassword,
            ],
            'password' => ['required', 'min:3', 'max:255', 'string']
        ];
    }
}
