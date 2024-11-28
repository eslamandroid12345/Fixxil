<?php

namespace App\Http\Services\Api\V1\App\Wallet;


use App\Http\Services\Api\V1\App\Wallet\WalletService;

class WalletMobileService extends WalletService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
