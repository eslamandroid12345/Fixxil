<?php

namespace App\Http\Requests\Api\V1\App\Complaint;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComplaintRequest extends FormRequest
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
                    'from' => ['nullable', Rule::exists('users','id')] ,
                    'to' => ['nullable', Rule::exists('users','id')] ,
                    'order_id' => ['required', Rule::exists('orders','id')] ,
                    'complaint' => 'required',
            ];
    }
}
