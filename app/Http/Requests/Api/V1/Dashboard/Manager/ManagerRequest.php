<?php

namespace App\Http\Requests\Api\V1\Dashboard\Manager;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
                'name' => 'required|max:255',
                'email' => $this->method() == 'POST'
                    ? Rule::unique('managers', 'email')
                    : Rule::unique('managers', 'email')->ignore(auth('api-manager')->id(), 'id'),
                'phone' => $this->method() == 'POST'
                    ? Rule::unique('managers', 'phone')
                    : Rule::unique('managers', 'phone')->ignore(auth('api-manager')->id(), 'id'),
//                'email' => 'required|unique',
//                'phone' => 'required|numeric',
                'password' => 'nullable|confirmed',
                'image' => 'nullable',
                'role' => 'required|exists:roles,id',
            ];
    }
}
