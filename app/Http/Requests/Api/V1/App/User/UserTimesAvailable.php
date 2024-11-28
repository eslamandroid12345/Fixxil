<?php

namespace App\Http\Requests\Api\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserTimesAvailable extends FormRequest
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
            'provider_id' => ['required',Rule::exists('users','id')] ,
            'day' => ['required',Rule::in([1,2,3,4,5,6,7])] ,
        ];
    }
}
