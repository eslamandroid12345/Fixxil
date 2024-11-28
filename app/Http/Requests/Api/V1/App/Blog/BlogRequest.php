<?php

namespace App\Http\Requests\Api\V1\App\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
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
                    'title' => 'nullable',
                    'content' => 'required',
                    'images' => 'nullable|array|min:1',
                    'images.*' => ['image', 'max:5120'],
            ];
    }
}
