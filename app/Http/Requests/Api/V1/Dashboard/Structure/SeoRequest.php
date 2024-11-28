<?php

namespace App\Http\Requests\Api\V1\Dashboard\Structure;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
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
            'content.ar.*.title' => 'required',
            'content.ar.*.description' => 'required',
            'content.en.*.title' => 'required',
            'content.en.*.description' => 'required',
            'content.ar.*.key' => 'required',
            'content.en.*.key' => 'required',
            'content.ar.*.meta' => 'required',
            'content.en.*.meta' => 'required',
        ];
    }
}
