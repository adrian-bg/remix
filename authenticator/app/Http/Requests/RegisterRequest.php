<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * The password must be at least 6 symbols and must contain characters
     * from at least three of the following five categories:
     * - English uppercase characters (A – Z)
     * - English lowercase characters (a – z)
     * - Base 10 digits (0 – 9)
     * - Non-alphanumeric (For example: !, $, #, or %)
     * - Unicode characters
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users|email:rfc',
            'password' => [
                'required',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            ]
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'password.regex' => __('validation.password_error_message'),
        ];
    }
}
