<?php

namespace App\Http\Enums;

enum OrderNegotiateStatus : string
{
    use Enumable;
    case UN_PRICED = 'un_priced';
    case PRICED = 'priced';
    case NEED_CHANGE = 'need_change';
    case FIXED_PRICE = 'fixed_price';

}
