<?php

namespace App\Http\Requests\Api\V1\App\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
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
            'order_id' => ['required', Rule::exists('orders', 'id'), Rule::unique('reviews', 'order_id')],
            'comment' => ['nullable', 'string', 'max:255'],
            'rates' => ['nullable', 'array'],
            'rates.*.question_id' => ['required', Rule::exists('questions', 'id')],
            'rates.*.rate' => ['required', 'numeric'],
        ];
    }
}
