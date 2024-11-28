<?php

namespace App\Http\Enums;

enum OfferStatus : string
{
    use Enumable;
    case INPROGRESS = 'in_progress';

    case Accept = 'accept';
    case REJECT = 'reject';

    public function validationRules()
    {
        $rules = [];
    }

    public function t()
    {
        return match ($this)
        {
            self::INPROGRESS => __('general.offer_in_progress'),
            self::Accept => __('general.accept'),
            self::REJECT => __('general.reject'),
        };
    }
}
