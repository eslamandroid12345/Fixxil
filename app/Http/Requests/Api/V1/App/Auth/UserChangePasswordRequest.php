<?php

namespace App\Http\Requests\Api\V1\App\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserChangePasswordRequest extends FormRequest
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
                    'phone' => ['required', Rule::exists('users', 'phone')],
                    'newpassword' => 'required|max:255|confirmed',
                ];
    }
}
