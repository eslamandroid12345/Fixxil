<?php

namespace App\Http\Requests\Api\V1\App\Wallet;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChargeRequest extends FormRequest
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
                    // 'point_counter' => 'required|numeric',
                    'package_id' => ['required', Rule::exists('packages', 'id')->where('is_active', true)],
                ];
    }
}
