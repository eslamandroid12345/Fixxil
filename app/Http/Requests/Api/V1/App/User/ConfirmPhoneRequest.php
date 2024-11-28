<?php

namespace App\Http\Requests\Api\V1\App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmPhoneRequest extends FormRequest
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
                    'confirm' => 'required|max:255',
                ];
    }
}
