<?php

namespace App\Http\Requests\Api\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;

class UserTimeRequest extends FormRequest
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
                    'user_times' => ['required', 'array','min:1'],
                    'user_times.*.day' => ['required', 'string'],
//                    'user_times.*.from' => ['required', 'string'],
                    'user_times.*.from' => ['required', 'date_format:H:i:s'],
                    'user_times.*.to' => ['required', 'date_format:H:i:s'],
//                    'user_times.*.to' => ['required', 'regex:/^([01]\d|2[0-3]):([0-5]\d)$/'],
//                    'user_times.*.to' => ['required', 'string'],
                ];
    }

    public function messages(): array
    {
        return [
            'user_times.*.from.date_format' => 'The from time must be in the format HH:MM:SS.',
            'user_times.*.to.date_format' => 'The to time must be in the format HH:MM:SS.',
        ];
    }
}
