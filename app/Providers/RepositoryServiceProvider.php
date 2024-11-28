<?php

namespace App\Providers;

use App\Repository\BlogImageRepositoryInterface;
use App\Repository\BlogRepositoryInterface;
use App\Repository\ChangeRepositoryInterface;
use App\Repository\CommentRepositoryInterface;
use App\Repository\CityRepositoryInterface;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\CityUserRepositoryInterface;
use App\Repository\Eloquent\ChangeRepository;
use App\Repository\Eloquent\UseCategoryRepository;
use App\Repository\Eloquent\UsesRepository;
use App\Repository\OtpRepositoryInterface;
use App\Repository\ReviewRatesRepositoryInterface;
use App\Repository\ReviewRepositoryInterface;
use App\Repository\SubCategoryUserRepositoryInterface;
use App\Repository\UseCategoryRepositoryInterface;
use App\Repository\UserServiceImageRepositoryInterface;
use App\Repository\UserTimeRepositoryInterface;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\QuestionRateRepositoryInterface;
use App\Repository\OfferRepositoryInterface;
use App\Repository\UsesRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Repository\WalletTransactionRepositoryInterface;
use App\Repository\ZoneRepositoryInterface;
use App\Repository\GovernorateRepositoryInterface;
use App\Repository\UnitRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\ChatRoomMessageRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\OrderImageRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\InfoRepositoryInterface;
use App\Repository\StructureRepositoryInterface;
use App\Repository\ContactUsRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use App\Repository\SubCategoryRepositoryInterface;
use App\Repository\RepositoryInterface;
use App\Repository\UserFixedServiceRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\ComplaintRepositoryInterface;
use App\Repository\PackageRepositoryInterface;
use App\Repository\UserPackageRepositoryInterface;
use App\Repository\NotificationRepositoryInterface;
use App\Repository\Eloquent\NotificationRepository;
use App\Repository\Eloquent\UserPackageRepository;
use App\Repository\Eloquent\PackageRepository;
use App\Repository\Eloquent\ComplaintRepository;
use App\Repository\Eloquent\StructureRepository;
use App\Repository\Eloquent\InfoRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\OrderImageRepository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\ChatRoomRepository;
use App\Repository\Eloquent\ChatRoomMemberRepository;
use App\Repository\Eloquent\ChatRoomMessageRepository;
use App\Repository\Eloquent\UnitRepository;
use App\Repository\Eloquent\ZoneRepository;
use App\Repository\Eloquent\GovernorateRepository;
use App\Repository\Eloquent\WalletRepository;
use App\Repository\Eloquent\WalletTransactionRepository;
use App\Repository\Eloquent\OfferRepository;
use App\Repository\Eloquent\QuestionRateRepository;
use App\Repository\Eloquent\QuestionRepository;
use App\Repository\Eloquent\CustomerReviewRepository;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\ReviewRatesRepository;
use App\Repository\Eloquent\ReviewRepository;
use App\Repository\Eloquent\UserTimeRepository;
use App\Repository\Eloquent\UserServiceImageRepository;
use App\Repository\Eloquent\SubCategoryUserRepository;
use App\Repository\Eloquent\UserFixedServiceRepository;
use App\Repository\Eloquent\CityUserRepository;
use App\Repository\Eloquent\CityRepository;
use App\Repository\Eloquent\BlogImageRepository;
use App\Repository\Eloquent\BlogRepository;
use App\Repository\Eloquent\CommentRepository;
use App\Repository\Eloquent\ManagerRepository;
use App\Repository\Eloquent\OrderRepository;
use App\Repository\Eloquent\Repository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\SubCategoryRepository;
use App\Repository\Eloquent\ContactUsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ManagerRepositoryInterface::class, ManagerRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(SubCategoryRepositoryInterface::class, SubCategoryRepository::class);
        $this->app->singleton(ContactUsRepositoryInterface::class, ContactUsRepository::class);
        $this->app->singleton(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->singleton(BlogImageRepositoryInterface::class, BlogImageRepository::class);
        $this->app->singleton(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(OrderImageRepositoryInterface::class, OrderImageRepository::class);
        $this->app->singleton(CityRepositoryInterface::class, CityRepository::class);
        $this->app->singleton(CityUserRepositoryInterface::class, CityUserRepository::class);
        $this->app->singleton(SubCategoryUserRepositoryInterface::class, SubCategoryUserRepository::class);
        $this->app->singleton(UserFixedServiceRepositoryInterface::class, UserFixedServiceRepository::class);
        $this->app->singleton(UserServiceImageRepositoryInterface::class, UserServiceImageRepository::class);
        $this->app->singleton(UserTimeRepositoryInterface::class, UserTimeRepository::class);
        $this->app->singleton(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->singleton(QuestionRateRepositoryInterface::class, QuestionRateRepository::class);
        $this->app->singleton(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->singleton(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->singleton(WalletTransactionRepositoryInterface::class, WalletTransactionRepository::class);
        $this->app->singleton(GovernorateRepositoryInterface::class, GovernorateRepository::class);
        $this->app->singleton(ZoneRepositoryInterface::class, ZoneRepository::class);
        $this->app->singleton(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->singleton(ChatRoomRepositoryInterface::class, ChatRoomRepository::class);
        $this->app->singleton(ChatRoomMemberRepositoryInterface::class, ChatRoomMemberRepository::class);
        $this->app->singleton(ChatRoomMessageRepositoryInterface::class, ChatRoomMessageRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(OtpRepositoryInterface::class, OtpRepository::class);
        $this->app->singleton(InfoRepositoryInterface::class, InfoRepository::class);
        $this->app->singleton(StructureRepositoryInterface::class, StructureRepository::class);
        $this->app->singleton(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->singleton(ReviewRatesRepositoryInterface::class, ReviewRatesRepository::class);
        $this->app->singleton(CustomerReviewRepositoryInterface::class, CustomerReviewRepository::class);
        $this->app->singleton(ComplaintRepositoryInterface::class, ComplaintRepository::class);
        $this->app->singleton(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->singleton(UserPackageRepositoryInterface::class, UserPackageRepository::class);
        $this->app->singleton(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->singleton(UseCategoryRepositoryInterface::class, UseCategoryRepository::class);
        $this->app->singleton(UsesRepositoryInterface::class, UsesRepository::class);
        $this->app->singleton(ChangeRepositoryInterface::class, ChangeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
