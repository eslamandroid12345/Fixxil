<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository implements OrderRepositoryInterface
{
    protected Model $model;

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getAllOrderDashboard($status, $rank)
    {
        return $this->model::query()
            ->when($status !== null, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'like', '%' .(int)request('search')-9999 . '%')
                        ->orWhereHas('customer', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', $searchTerm);
                        })
                        ->orWhereHas('provider', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', $searchTerm);
                        });
                });
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->when(request()->has('rank') && request('rank') !== null, function ($query) {
                $query->orderBy('created_at', request('rank') == 1 ? 'desc' : 'asc');
            })
            ->paginate(request('perPage'));
    }

    public function getOrderHasOffers()
    {
        return $this->model::query()
            ->where('customer_id', auth('api-app')->id())
            ->where('provider_id', null)
            ->where('is_active', 1)
            ->orderByDesc('importance')
            ->latest()
            ->get();
    }

    public function getOrderForUser($id, $status = null)
    {
        $query = $this->model::query()->where('customer_id', $id);
        if ($status !== null) {
            $query->where('status', $status);
        }
        $query->orderByDesc('importance');
        $query->where('is_active', 1);
        return $query->get();
    }

    public function getNewOrderForProviderHome()
    {
        $subCategories = auth('api-app')->user()?->subCategories()?->pluck('sub_categories.id');
        $cities = auth('api-app')->user()?->cities()?->pluck('cities.id');
        return $this->model::query()
            ->whereNull('provider_id')
            ->WhereIn('sub_category_id', $subCategories)
            ->WhereIn('city_id', $cities)
            ->where('is_active', 1)
            ->latest()->orderByDesc('importance')->take(6)->get();
    }

    public function getOrderForProvider($id, $status)
    {
        return $this->model::query()->where('provider_id', $id)->where('status', $status)->where('is_active', 1)->latest()->orderByDesc('importance')->get();
    }

    public function getOrderNotHavOffer($id)
    {
        return $this->model::query()->whereNull('provider_id')
            ->when(request()->has('category_id') && request('category_id') != null, function ($q) {
                $categoryId = request('category_id');
                $q->whereHas('subcategory', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                });
            })
            ->orderByDesc('importance')
            ->where('is_active', 1)
            ->latest()->paginate(15);
    }

    public function getOrdersForCustomer($id, $status)
    {
        // return $this->model::query()->where('customer_id', $id)->where('status', $status)->whereNotNull('provider_id')
        //     ->latest()->orderByDesc('importance')->get();
        return $this->model::query()->where('customer_id', $id)->where('status', $status)->where('is_active', 1)->latest()->orderByDesc('importance')->get();
    }

    public function getAllOrderFinishedProvider($id)
    {
        return $this->model::query()->where('provider_id', $id)->where('status', 'finished')
            ->latest()->orderByDesc('importance')->get();
    }

    public function getAllOrdersComplaint($id)
    {
        return $this->model::query()->where('provider_id', $id)->orWhere('customer_id', $id)->latest()->get();
    }

    public function getOrdersForProvider($id)
    {
        return $this->model::query()
            ->whereNull('provider_id')
            ->whereHas('offers', function ($query) use ($id) {
                $query->where('provider_id', $id)->where('status', 'in_progress');
            })
            ->latest()
            ->orderByDesc('importance')
            ->where('is_active', 1)
            ->get();
    }

    public function getLastOrders()
    {
        return $this->model::query()
            ->latest()
            ->orderByDesc('importance')
            ->take(5)->get();
    }

}
