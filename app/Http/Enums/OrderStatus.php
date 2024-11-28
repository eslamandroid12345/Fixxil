<?php

namespace App\Http\Enums;

enum OrderStatus : string
{
    use Enumable;
    case CREATED = 'created';
    case AWAITING = 'awaiting';
    case IN_PROGRESS = 'in_progress';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';

    public function validationRules()
    {
        $rules = [];



    }

    public function t()
    {
        return match ($this) {
            self::CREATED => __('general.created'),
            self::AWAITING => __('general.awaiting'),
            self::IN_PROGRESS => __('general.in_progress'),
            self::FINISHED => __('general.finished'),
            self::CANCELED => __('general.canceled'),
        };
    }
}
