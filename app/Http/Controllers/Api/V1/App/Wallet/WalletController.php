<?php

namespace App\Http\Controllers\Api\V1\App\Wallet;

use App\Http\Controllers\Controller;
use Exception;
use App\Http\Requests\Api\V1\App\Wallet\ChargeRequest;
use App\Http\Services\Api\V1\App\Wallet\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function __construct(private readonly WalletService $wallet)
    {
        $this->middleware('auth:api-app');
    }

    public function getTotal()
    {
        return $this->wallet->getTotal();
    }

    public function getPointDetails()
    {
        return $this->wallet->getPointDetails();
    }

    public function charge(ChargeRequest $request)
    {
        return $this->wallet->charge($request);
    }

    public function getTotalCharge(ChargeRequest $request)
    {
        return $this->wallet->getTotalCharge($request);
    }

    public function getAllDeposit()
    {
        return $this->wallet->getAllDeposit();
    }
}
