<?php

namespace App\Http\Enums;

enum ChangeTypeEnum: string
{
    use Enumable;

    case MAIN_DETAILS = 'MAIN_DETAILS';
    case SERVICE_IMAGES = 'SERVICE_IMAGES';

    public function validationRules()
    {
        $rules = [];
    }

    public function t()
    {
        return match ($this) {
            self::SERVICE_IMAGES => __('messages.SERVICE_IMAGES'),
            self::MAIN_DETAILS => __('messages.MAIN_DETAILS'),
        };
    }
}
