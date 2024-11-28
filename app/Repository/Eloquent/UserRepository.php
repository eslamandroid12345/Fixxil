<?php

namespace App\Repository\Eloquent;

use App\Repository\InfoRepositoryInterface;
use Carbon\Carbon;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getProfile()
    {
        $user = auth('api-app')->user();
        $user->load(['providerNewOrders', 'cities',
            'fixedServices', 'serviceImages', 'workTime']);
        $user->loadCount(['myOrders', 'myOffers']);
        return $user;
    }

    public function getAllUsers()
    {
        return $this->model::query()
            ->when(request()->has('search') && request('search') != null, function ($q) {
                $searchTerm = '%' . request('search') . '%';
                $q->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm);
                });
            })
            ->when(request()->has('type') && request('type') != null, function ($q) {
                $q->where('type', request('type'));
            })
            ->when(request()->has('is_active') && request('is_active') != null, function ($q) {
                $q->where('is_active', request('is_active'));
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request('perPage'));
    }

    public function getActiveUsers()
    {
        return $this->model::query()->where('is_active', true);
    }

    public function getAllUsersBySubCategory($id)
    {
        $subCategoryId = request()->has('sub_category_id') ? request('sub_category_id') : $id;
        $query = $this->model::query()->where('is_active', true)
            ->when(request()->has('name') && request('name') != null, function ($q) {
                $searchTerm = '%' . request('name') . '%';
                $q->where('name', 'like', $searchTerm);
            })
            ->when(request()->has('city_id') && request('city_id') != null, function ($q) {
                $q->where('city_id', request('city_id'));
            })
            ->when(request()->has('is_verified') && request('is_verified') != null, function ($q) {
                $q->where('is_verified', 1);
            })->whereHas('subCategories', function ($q) use ($subCategoryId) {
                $q->where('sub_categories.id', $subCategoryId);
            });
        $users = $query->get();
        if (request()->has('higher_rate') && request('higher_rate') == 1)
            return $users->sortByDesc('averageRate');
        elseif (request()->has('lower_rate') && request('lower_rate') == 1)
            return $users->sortBy('averageRate');
        return $users;
    }

    public function getUserBySubCategory($subcategory_id, $id)
    {
        $user = $this->model::query()->where('is_active', true)->where('id', $id)->first();
        $sum = 0;
        foreach ($user->questionRateProviders as $item) {
            $sum += $item->rate;
        }
        if ($user->questionRateProviderCount() > 0) {
            $user->avarage = round($user->avarage = $sum / $user->questionRateProviderCount(), 1);
        } else {
            $user->avarage = round($user->avarage = $sum / 1, 1);
        }
        $lastSeen = Carbon::parse($user->last_seen);
        $weekAgo = Carbon::now()->subWeek();
        $user->last_seen = $lastSeen->greaterThan($weekAgo) ? 1 : 0;
//        $user->subcategory = $user->subCategories()->find($subcategory_id);
        return $user;
    }

    public function withdrawPointsFromWallet($provider_id)
    {
        return $this->model::query()
            ->where('id', $provider_id)
            ->decrement('wallet', app(InfoRepositoryInterface::class)->pointDiscount());
    }

    public function getUserBySearch($request)
    {
        return $this->model::query()
            ->where('is_active', true)
            ->where('type', 'provider')
            ->when(request()->has('search') && request('search') != null, function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->get();
    }

    public function getLastUsers()
    {
        return $this->model::query()
            ->latest()
            ->take(5)->get();
    }

    public function checkItem($byColumn, $value)
    {
        return $this->model::query()->where($byColumn, $value)->first();
    }

}
