<?php

namespace App\Http\Middleware;

use App\Http\Traits\Responser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Type
{
    use Responser;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $type): Response
    {
        if (auth('api-app')->user()?->type !== $type && auth('api-app')->check())
            return $this->responseFail(message: __('messages.You are not authorized to access this Package'));
        return $next($request);
    }
}
