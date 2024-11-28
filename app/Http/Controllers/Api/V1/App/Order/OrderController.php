<?php

namespace App\Http\Controllers\Api\V1\App\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Order\OrderChangeActionRequest;
use App\Http\Requests\Api\V1\App\Order\OrderChooseOfferRequest;
use App\Http\Requests\Api\V1\App\Order\OrderRequest;
use Exception;
use App\Http\Services\Api\V1\App\Order\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct(private readonly OrderService $order)
    {
        $this->middleware('auth:api-app');
        $this->middleware('type:customer')->only(['chooseOffer','request']);
    }

    public function request(OrderRequest $request)
    {
        return $this->order->request($request);
    }
    public function requestProvider(OrderRequest $request)
    {
        return $this->order->requestProvider($request);
    }
    public function chooseOffer(OrderChooseOfferRequest $request)
    {
        return $this->order->chooseOffer($request);
    }
    public function changeAction(OrderChangeActionRequest $request)
    {
        return $this->order->changeAction($request);
    }

    public function hasOffers()
    {
        return $this->order->hasOffers();
    }

    public function oneOrderHasOffer($id)
    {
        return $this->order->oneOrderHasOffer($id);
    }

    public function getOrderForUser(Request $request)
    {
        return $this->order->getOrderForUser($request);
    }

    public function getOrders(Request $request)
    {
        return $this->order->getOrders($request);
    }

    public function home()
    {
        return $this->order->getOrdersHome();
    }

    public function getOneNewOrder($id)
    {
        return $this->order->getOneNewOrder($id);
    }
    public function cancelOrder($id)
    {
        return $this->order->cancelOrder($id);
    }

//    public function getInprogressOrder()
//    {
//        return $this->order->getInprogressOrder();
//    }
//
//    public function getFinishedOrder()
//    {
//        return $this->order->getFinishedOrder();
//    }

    public function getOrderNotHavOffer()
    {
        return $this->order->getOrderNotHavOffer();
    }

    public function getOrdersCustomer(Request $request)
    {
        return $this->order->getOrdersCustomer($request);
    }

    public function getOneNewOrderCustomer($id)
    {
        return $this->order->getOneNewOrderCustomer($id);
    }

    public function showOneOrder($id)
    {
        return $this->order->showOneOrder($id);
    }

//    public function getInprogressOrderCustomer()
//    {
//        return $this->order->getInprogressOrderCustomer();
//    }
//
//    public function getFinishedOrderCustomer()
//    {
//        return $this->order->getFinishedOrderCustomer();
//    }
}
