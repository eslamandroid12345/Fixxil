<?php

namespace App\Http\Services\Api\V1\Dashboard\IndexDashboard;

use App\Http\Requests\Api\V1\Dashboard\Category\CategoryRequest;
use App\Http\Resources\V1\Dashboard\Blog\BlogCollection;
use App\Http\Resources\V1\Dashboard\Blog\BlogGeneralResource;
use App\Http\Resources\V1\Dashboard\Order\OrderResource;
use App\Http\Resources\V1\Dashboard\Transaction\TransactionResource;
use App\Http\Resources\V1\Dashboard\User\UserResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\GeneralTrait;
use App\Repository\ContactUsRepositoryInterface;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\BlogRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;
use App\Repository\GovernorateRepositoryInterface;
use App\Repository\CityRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use App\Repository\ZoneRepositoryInterface;
use App\Repository\UnitRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;

class IndexDashboardService
{
    use Responser;
    use GeneralTrait;

    public function __construct(
        private readonly UserRepositoryInterface        $userRepository,
        private readonly OrderRepositoryInterface       $orderRepository,
        private readonly BlogRepositoryInterface        $blogRepository,
        private readonly CategoryRepositoryInterface    $categoryRepository,
        private readonly SubCategoryRepositoryInterface $subcategoryRepository,
        private readonly GovernorateRepositoryInterface $governorateRepository,
        private readonly CityRepositoryInterface        $cityRepository,
        private readonly ZoneRepositoryInterface        $zoneRepository,
        private readonly ContactUsRepositoryInterface   $contactusRepository,
        private readonly UnitRepositoryInterface        $unitRepository,
        private readonly WalletTransactionRepositoryInterface        $transactionRepository,
        private readonly ManagerRepositoryInterface     $managerRepository,
        private readonly GetService                     $getService,
        private readonly FileManagerService             $fileManagerService
    )
    {
    }
    public function index()
    {
        $customersCount = $this->userRepository->count('type', 'customer');
        $providersCount = $this->userRepository->count('type', 'provider');
        $ordersCount = $this->orderRepository->count();
        $blogsCount = $this->blogRepository->getAllBlogsCount();
        $categoriesCount = $this->categoryRepository->count();
        $subcategoriesCount = $this->subcategoryRepository->count();
        $governoratesCount = $this->governorateRepository->count();
        $citiesCount = $this->cityRepository->count();
        $zonesCount = $this->zoneRepository->count();
        $conatctusCount = $this->contactusRepository->count();
        $unitsCount = $this->unitRepository->count();
        $managersCount = $this->managerRepository->getCount();

        $data = [
            'statics' => [
                'customersCount' => $customersCount,
                'providersCount' => $providersCount,
                'ordersCount' => $ordersCount,
                'blogsCount' => $blogsCount,
                'categoriesCount' => $categoriesCount,
                'subcategoriesCount' => $subcategoriesCount,
                'governoratesCount' => $governoratesCount,
                'citiesCount' => $citiesCount,
                'zonesCount' => $zonesCount,
                'conatctusCount' => $conatctusCount,
                'unitCount' => $unitsCount,
                'managersCount' => $managersCount,
            ],
            'orders' => OrderResource::collection($this->orderRepository->getLastOrders()),
            'users' => UserResource::collection($this->userRepository->getLastUsers()),
            'transactions' => TransactionResource::collection($this->transactionRepository->getLastTransactions()),
            'questions' => BlogGeneralResource::collection($this->blogRepository->getLastQuestions()),
            'blogs' => BlogGeneralResource::collection($this->blogRepository->getLastBlogs()),
        ];
        return $this->returnData('data', $data);
    }
}
