<?php

namespace App\Http\Requests\Api\V1\Dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
                    'email' => 'required|email|max:255',
                    'phone' => 'required|max:255',
                    'password' => 'nullable|confirmed|max:255',
                    'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
                ];
    }
}
