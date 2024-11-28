<?php

namespace App\Http\Requests\Api\V1\App\Auth;
use App\Http\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignUpRequest extends FormRequest
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
        return UserType::from($this->route()->parameter('user'))->validationRules();
    }
    public function messages(): array
    {
        return [
            'phone.regex' => __('messages.The phone number must be a valid Egyptian number (e.g., 01XXXXXXXXX).'),
        ];
    }
}
