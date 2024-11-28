<?php

namespace App\Http\Requests\Api\V1\Dashboard\CustomerReview;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerReviewRequest extends FormRequest
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
        $rules = [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'job_title_ar' => ['required', 'string'],
            'job_title_en' => ['required', 'string'],
            'review_ar' => ['required', 'string'],
            'review_en' => ['required', 'string'],
        ];

        // Add conditional validation rules for 'image' field
        if ($this->isMethod('POST'))
        {
            $rules['image'] = ['required', 'image'];
        }
        elseif ($this->isMethod('PUT'))
        {
            $rules['image'] = ['nullable', 'image'];
        }

        return $rules;
    }
}
