<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            if (app()->isProduction()) {
                Route::group([
                    'middleware' => ['api', 'localize-api'],
                    'domain' => env('PRODUCTION_API_SUBDOMAIN')
                ], function () {
                    Route::prefix('api/v1')->group(function () {
                        Route::prefix('website')->group(base_path('routes/api/v1/website.php'));
                        Route::prefix('mobile')->group(base_path('routes/api/v1/mobile.php'));
                        Route::prefix('dashboard')->group(base_path('routes/api/v1/dashboard.php'));
                    });
                });

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));
            } else {
                Route::group(['middleware' => ['api', 'localize-api']], function () {
                    Route::prefix('api/v1')->group(function () {
                        Route::prefix('website')->group(base_path('routes/api/v1/website.php'));
                        Route::prefix('mobile')->group(base_path('routes/api/v1/mobile.php'));
                        Route::prefix('dashboard')->group(base_path('routes/api/v1/dashboard.php'));
                    });
                });

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));
            }


        });
    }
}
