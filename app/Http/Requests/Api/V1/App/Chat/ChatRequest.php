<?php

namespace App\Http\Requests\Api\V1\App\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChatRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::notIn([auth('api-manager')->id()]), Rule::exists('users', 'id')->where('is_active', true)],
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'status' => ['required', 'in:OPEN,CLOSE'],
        ];
    }
}
