<?php

namespace App\Http\Requests\Api\V1\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'image' => ($this->isMethod('post') ? 'required' : 'nullable') . '|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'indexx' => 'required|integer',
        ];
    }
}
