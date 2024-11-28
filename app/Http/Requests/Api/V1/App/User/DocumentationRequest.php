<?php

namespace App\Http\Requests\Api\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;

class DocumentationRequest extends FormRequest
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
                    'national_id' => 'required',
                    'criminal_record_sheet' => ['nullable','image', 'mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp,image/svg+xml,image/x-icon', 'max:5120'],
                    'national_id_image' => ['nullable','image', 'mimetypes:image/jpeg,image/png,image/gif,image/bmp,image/webp,image/svg+xml,image/x-icon', 'max:5120'],
                ];
    }
}
