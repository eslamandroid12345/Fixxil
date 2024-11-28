<?php

namespace App\Http\Middleware;

use App\Http\Traits\Responser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    use Responser;

    const NOT_ACTIVE = 0;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api-app')->user()?->is_active == self::NOT_ACTIVE && auth('api-app')->check()) {
            auth('api-app')->logout();
            return $this->responseFail(status: 401, message: __('messages.Your account is deactivated .'));
        }

        return $next($request);
    }
}
