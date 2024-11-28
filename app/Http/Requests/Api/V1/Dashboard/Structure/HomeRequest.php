<?php

namespace App\Http\Requests\Api\V1\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class HomeRequest extends FormRequest
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
            'content.en.first_section.title' => 'required|max:255',
            'content.ar.first_section.title' => 'required|max:255',
            'content.en.first_section.image' => 'required|string',
            'content.ar.first_section.image' => 'required|string',

            'content.en.why_choose.reasons.*' => 'required|string',
            'content.ar.why_choose.reasons.*' => 'required|string',
            'content.en.why_choose.title' => 'required|string',
            'content.ar.why_choose.title' => 'required|string',
            'content.en.why_choose.providers_number' => 'required|numeric',
            'content.ar.why_choose.providers_number' => 'required|numeric',
            'content.en.why_choose.image' => 'required|string',
            'content.ar.why_choose.image' => 'required|string',

            'content.ar.footer.image' => 'required|string',
            'content.en.footer.image' => 'required|string',
            'content.en.footer.desc' => 'nullable',
            'content.ar.footer.desc' => 'nullable',

            'content.en.mobile.title' => 'required|string',
            'content.ar.mobile.title' => 'required|string',
            'content.ar.mobile.google_link' => 'required|url',
            'content.en.mobile.google_link' => 'required|url',
            'content.ar.mobile.apple_link' => 'required|url',
            'content.en.mobile.apple_link' => 'required|url',
            'content.en.mobile.image' => 'required|string',
            'content.ar.mobile.image' => 'required|string',

            'files' => 'nullable|array',
            'files.*' => 'required|image',
            'old_files' => 'nullable|array',
            'old_files.*' => 'required|url',
        ];
    }
}
