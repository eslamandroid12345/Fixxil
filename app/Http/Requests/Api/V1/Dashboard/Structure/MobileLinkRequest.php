<?php

namespace App\Http\Requests\Api\V1\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class MobileLinkRequest extends FormRequest
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
            'content.ar.*.title'=>'required|string',
            'content.ar.*.content'=>'required|string',
            'content.en.*.title'=>'required|string',
            'content.en.*.content'=>'required|string',
            'content.en.*.image'=>'required|string',
            'content.ar.*.image'=>'required|string',
            'content.en.*.google_link'=>'required|url',
            'content.ar.*.google_link'=>'required|url',
            'content.en.*.apple_link'=>'required|url',
            'content.ar.*.apple_link'=>'required|url',

            'files' => 'nullable|array',
            'files.*' => 'required|image',
            'old_files' => 'nullable|array',
            'old_files.*' => 'required|url',
        ];
    }
}
