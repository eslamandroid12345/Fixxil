<?php

namespace App\Http\Requests\Api\V1\Dashboard\Uses;

use Illuminate\Foundation\Http\FormRequest;

class UsesRequest extends FormRequest
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
                    'name_en' => 'required|max:255',
                    'name_ar' => 'required|max:255',
                    'video_link' => 'required|max:255',
                    'description_en' => 'required|string',
                    'description_ar' => 'required|string',
                    'indexx' => 'required|integer',
                ];
    }
}
