<?php

namespace App\Http\Requests\Api\V1\Dashboard\SubCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryRequest extends FormRequest
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
            'category_id' => ['required', Rule::exists('categories','id')] ,
            'name_en' => 'required|max:255',
            'name_ar' => 'required|max:255',
            'indexx' => 'required|integer',
        ];
    }
}
