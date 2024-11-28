<?php

namespace App\Http\Enums;

enum OrderAction : string
{
    use Enumable;
    case GO_TO_LOCATION = 'go_to_location';
    case START_SERVICE = 'start_service';
    case FINISH_SERVICE = 'finish_service';

    public function validationRules()
    {
        $rules = [];



    }

    public function t()
    {
        return match ($this) {
            self::GO_TO_LOCATION => __('general.go_to_location'),
            self::START_SERVICE => __('general.start_service'),
            self::FINISH_SERVICE => __('general.finish_service'),
        };
    }
}
