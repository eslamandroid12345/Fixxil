<?php

namespace App\Http\Services\Api\V1\App\Wallet;

use App\Http\Services\Api\V1\App\Wallet\WalletService;

class WalletWebService extends WalletService
{
    public static function platform(): string
    {
        return 'website';
    }
}
