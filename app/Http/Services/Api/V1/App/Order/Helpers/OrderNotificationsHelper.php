<?php

namespace App\Http\Services\Api\V1\App\Order\Helpers;

use App\Http\Traits\Notification;
use App\Notifications\OrderSameCategoryNotification;
use App\Notifications\RequestOrderNotification;
use App\Repository\SubCategoryRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class OrderNotificationsHelper
{
    use Notification;

    public function __construct(
        private readonly UserRepositoryInterface        $userRepository,
        private readonly SubCategoryRepositoryInterface $categoryRepository,
    )
    {

    }

    public function sendForProvidersInCategory($sub_category_id, $order_id)
    {
        $category = $this->categoryRepository->getById($sub_category_id, columns: ['id', 'name_ar', 'name_en'], relations: ['providers:id,fcm']);
        $this->SendNotification(OrderSameCategoryNotification::class, $category->providers, [
            'order_id' => $order_id,
            'category_name' => $category->t('name'),
        ]);
    }

    public function sendProviderNotification($provider_id, $order_id)
    {
        $provider = $this->userRepository->getById($provider_id, ['id', 'fcm']);
        $this->SendNotification(RequestOrderNotification::class, $provider, [
            'order_id' => $order_id,
            'user_name' => auth('api-app')->user()?->name,
        ]);
    }
}
