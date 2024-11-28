<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FcmUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api-app')->check() && $request->header('fcm') != null && $request->header('fcm') != auth('api-app')->user()?->fcm)
            auth('api-app')->user()?->update(['fcm' => $request->header('fcm')]);
        return $next($request);
    }
}
