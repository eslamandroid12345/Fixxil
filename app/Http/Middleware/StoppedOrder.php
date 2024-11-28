<?php

namespace App\Http\Middleware;

use App\Http\Traits\Responser;
use App\Repository\OrderRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoppedOrder
{
    use Responser;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $parameter = 'order'): Response
    {
        $order_id = $request->{$parameter};
        $order = app(OrderRepositoryInterface::class)->getByID($order_id, ['id', 'is_stopped']);
        if (!Gate::allows('access-order', $order) && $order)
            return $this->responseFail(message: __('messages.This order has been stopped for some reason.'));
        return $next($request);
    }
}
