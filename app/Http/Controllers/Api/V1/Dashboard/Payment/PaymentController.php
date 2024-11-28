<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Payment;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Payment\PaymentService;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentService $payment)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:payment-read')->only('index' , 'show');
    }
    public function index()
    {
        return $this->payment->index();
    }
    public function show($id)
    {
        return $this->payment->show($id);
    }
}
