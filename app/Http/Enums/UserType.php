<?php

namespace App\Http\Enums;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
enum UserType : string
{
    use Enumable;
    case PROVIDER = 'provider';
    case CUSTOMER = 'customer';

    public function validationRules()
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email:rfc,dns', Rule::unique('users', 'email'), ],
            'password' => ['required', Password::min(8)->symbols()->letters()],
            'phone' => ['required','numeric', 'regex:/^0(10|11|12|15)\d{8}$/' , Rule::unique('users', 'phone')],
            'city_id' => ['required', Rule::exists('cities','id')],
            'zone_id' => ['required', Rule::exists('zones','id')],
            'governorate_id' => ['required', Rule::exists('governorates','id')],
            'address' => ['required', 'string'],
            'image' => ['nullable', 'exclude', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
        return match ($this) {
            self::CUSTOMER => $rules,
            self::PROVIDER => $rules + [
                    'about' => ['required', 'string'],
                    'national_id' => ['required', Rule::unique('users', 'national_id'),'digits:14'],
                    'national_id_image' => ['required', 'exclude', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    'criminal_record_sheet' => ['nullable', 'exclude', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                    'services' => ['required', 'array', 'min:1'],
                    'cities' => ['required', 'array', 'min:1'],
                    'fixed_services' => ['nullable', 'array', 'min:1'],
                    'fixed_services.*.name' => ['nullable', 'string'],
                    'fixed_services.*.price' => ['nullable', 'numeric'],
                    'fixed_services.*.unit_id' => ['nullable', 'exists:units,id'],
                    'services_images' => ['required', 'array', 'min:1'],
                ]
        };
    }

    public function t()
    {
        return match ($this) {
            self::CUSTOMER => __('general.customer'),
            self::PROVIDER => __('general.provider'),
        };
    }
}
