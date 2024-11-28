<?php

namespace App\Http\Requests\Api\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;

class UserServiceRequest extends FormRequest
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
                    'services' => ['nullable', 'array', 'min:1'],
                    'cities' => ['nullable', 'array', 'min:1'],
                    'cities.*' => 'exists:cities,id',
                    'fixed_services' => ['nullable', 'array', 'min:1'],
                    'fixed_services.*.name' => ['nullable', 'string'],
                    'fixed_services.*.price' => ['nullable', 'numeric'],
                    'about' => 'nullable',
                    'services_images' => ['nullable', 'array', 'min:1'],
                ];
    }
}
