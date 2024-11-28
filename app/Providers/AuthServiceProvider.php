<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {


        Gate::define('add-rate', function ($user, $order) {
            return $order->customer_id == $user->id && $order->provider_id != null
            && $order->status != OrderStatus::FINISHED->value
                ? Response::allow() : Response::deny();
        });

        Gate::define('access-order', function (User $user, $order) {
            return !$order->is_stopped;
        });

        Gate::define('update-review', function ($user, $review) {
            return $review->customer_id == auth('api-app')->id()
            && !$review->rated
                ? Response::allow() : Response::deny();
        });

        Gate::define('access-room', function ($user, $room) {
            return $room->members?->contains('user_id', auth('api-app')->id()) && $room->status == 'OPEN';
        });
    }
}
