<?php

namespace App\Http\Requests\Api\V1\App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePhoneRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                        'required',
                        'numeric',
                        'regex:/^0(10|11|12|15)\d{8}$/',
                        Rule::unique('users', 'phone')->ignore(auth('api-app')->id()), // Ignore unique validation for the current authenticated user
                    ],
                ];
    }
}
