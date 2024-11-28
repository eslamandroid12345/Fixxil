<?php

namespace App\Http\Enums;

enum ComplaintStatus : string
{
    use Enumable;
    case INPROGRESS = 'in_progress';
    case DOING = 'doing';
    case DONE = 'done';

    public function validationRules()
    {
        $rules = [];
    }

    public function t()
    {
        return match ($this)
        {
            self::INPROGRESS => __('general.offer_in_progress'),
            self::DOING => __('general.doing'),
            self::DONE => __('general.done'),
        };
    }
}
