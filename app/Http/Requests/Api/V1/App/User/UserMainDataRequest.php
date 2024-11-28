<?php

namespace App\Http\Requests\Api\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;

class UserMainDataRequest extends FormRequest
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
                    'email' => 'nullable|email|max:255',
                    'phone' => 'required|max:255',
                    'password' => 'nullable',
                    'address' => 'required',
                    'about' => 'nullable',
                    'governorate_id' => 'required',
                    'city_id' => 'required',
                    'zone_id' => 'required',
                    'national_id' => 'nullable',
//                    'image' => ['nullable', 'exclude', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    'image' => ['nullable','image', 'mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp,image/svg+xml,image/x-icon', 'max:5120'],
                ];
    }
}
