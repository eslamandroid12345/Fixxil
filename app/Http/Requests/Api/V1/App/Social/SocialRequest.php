<?php

namespace App\Http\Requests\Api\V1\App\Social;

use Illuminate\Foundation\Http\FormRequest;

class SocialRequest extends FormRequest
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
                    'email' => 'required|email',
                    'image' => 'nullable',
                    'provider_id' => 'required',
                    'provider' => 'required',
                ];
    }
}
