<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Order\OrderService;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $order)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:order-read')->only('index' , 'show');
        $this->middleware('permission:order-update')->only('changeStatus' , 'stop');
        $this->middleware('permission:order-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        return $this->order->index($request);
    }

    public function show($id)
    {
        return $this->order->show($id);
    }

    public function destroy($id)
    {
        return $this->order->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->order->changeStatus($request,$id);
    }
    public function stop($id)
    {
        return $this->order->stop($id);
    }

    public function getOrderMessage($id)
    {
        return $this->order->getOrderMessage($id);
    }
}
