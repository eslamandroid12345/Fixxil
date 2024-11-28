<?php

namespace App\Http\Services\Api\V1\Dashboard\Payment;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\WalletTransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Payment\PaymentResource;
use App\Http\Resources\V1\Dashboard\Payment\PaymentCollection;

class PaymentService
{
    use Responser;

    public function __construct(
        private readonly WalletTransactionRepositoryInterface $walletTransactionRepository,
        private readonly GetService                   $getService,
        private readonly FileManagerService           $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(PaymentCollection::class, $this->walletTransactionRepository,method: 'getAllPayments',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(PaymentResource::class, $this->walletTransactionRepository, method: 'getById', parameters: [$id], is_instance: true);
    }
}
