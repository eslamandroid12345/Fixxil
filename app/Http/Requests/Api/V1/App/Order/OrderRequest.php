<?php

namespace App\Http\Requests\Api\V1\App\Order;

use App\Http\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'provider_id' => ['nullable', Rule::exists('users', 'id')->where('type', UserType::PROVIDER->value)->where('is_active', true)],
//            'at' => ['nullable', 'date', 'date_format:Y-m-d g:i:s', 'after:now'],
            'sub_category_id' => ['required', Rule::exists('sub_categories', 'id')->where('is_active', true)],
            'city_id' => ['required', Rule::exists('cities', 'id')->where('is_active', true)],
            'zone_id' => ['required', Rule::exists('zones', 'id')->where('is_active', true)],
//            'zone_id' => ['required', 'string'],
            'address' => ['required', 'string'],
            'price' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'importance' => ['required' , Rule::in(1,2,3)] ,
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:5120'],
        ];
    }
}
