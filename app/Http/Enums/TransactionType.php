<?php

namespace App\Http\Enums;

enum TransactionType : string
{
    use Enumable;
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';

    public function validationRules()
    {
        $rules = [];
    }

    public function t()
    {
        return match ($this) {
            self::WITHDRAW => __('general.withdraw'),
            self::DEPOSIT => __('general.deposit'),
        };
    }
}
