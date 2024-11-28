<?php

namespace App\Providers;

use App\Http\Services\Api\V1\App\Negotiates\NegotiatesMobileService;
use App\Http\Services\Api\V1\App\Negotiates\NegotiatesService;
use App\Http\Services\Api\V1\App\Negotiates\NegotiatesWebService;
use App\Http\Services\Api\V1\App\Order\OrderMobileService;
use App\Http\Services\Api\V1\App\Order\OrderService;
use App\Http\Services\Api\V1\App\Order\OrderWebService;
use App\Http\Services\Api\V1\Dashboard\Auth\AuthMobileService;
use App\Http\Services\Api\V1\Dashboard\Auth\AuthService;
use App\Http\Services\Api\V1\Dashboard\Auth\AuthWebService;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\Api\V1\App\ContactUs\ContactUsService;
use App\Http\Services\Api\V1\App\ContactUs\ContactUsMobileService;
use App\Http\Services\Api\V1\App\ContactUs\ContactUsWebService;
use App\Http\Services\Api\V1\App\Blog\BlogService;
use App\Http\Services\Api\V1\App\Blog\BlogMobileService;
use App\Http\Services\Api\V1\App\Blog\BlogWebService;
use App\Http\Services\Api\V1\App\Category\CategoryService;
use App\Http\Services\Api\V1\App\Category\CategoryWebService;
use App\Http\Services\Api\V1\App\Category\CategoryMobileService;
use App\Http\Services\Api\V1\App\Auth\AuthAppService;
use App\Http\Services\Api\V1\App\Auth\AuthAppWebService;
use App\Http\Services\Api\V1\App\Auth\AuthAppMobileService;
use App\Http\Services\Api\V1\App\City\CityService;
use App\Http\Services\Api\V1\App\City\CityWebService;
use App\Http\Services\Api\V1\App\City\CityMobileService;
use App\Http\Services\Api\V1\App\User\UserService;
use App\Http\Services\Api\V1\App\User\UserWebService;
use App\Http\Services\Api\V1\App\User\UserMobileService;
use App\Http\Services\Api\V1\App\UserHome\UserHomeService;
use App\Http\Services\Api\V1\App\UserHome\UserHomeWebService;
use App\Http\Services\Api\V1\App\UserHome\UserHomeMobileService;
use App\Http\Services\Api\V1\App\Question\QuestionService;
use App\Http\Services\Api\V1\App\Question\QuestionWebService;
use App\Http\Services\Api\V1\App\Question\QuestionMobileService;
use App\Http\Services\Api\V1\App\Comment\CommentService;
use App\Http\Services\Api\V1\App\Comment\CommentWebService;
use App\Http\Services\Api\V1\App\Comment\CommentMobileService;
use App\Http\Services\Api\V1\App\Offer\OfferService;
use App\Http\Services\Api\V1\App\Offer\OfferWebService;
use App\Http\Services\Api\V1\App\Offer\OfferMobileService;
use App\Http\Services\Api\V1\App\Wallet\WalletService;
use App\Http\Services\Api\V1\App\Wallet\WalletWebService;
use App\Http\Services\Api\V1\App\Wallet\WalletMobileService;
use App\Http\Services\Api\V1\App\Governorate\GovernorateService;
use App\Http\Services\Api\V1\App\Governorate\GovernorateWebService;
use App\Http\Services\Api\V1\App\Governorate\GovernorateMobileService;
use App\Http\Services\Api\V1\App\Zone\ZoneService;
use App\Http\Services\Api\V1\App\Zone\ZoneWebService;
use App\Http\Services\Api\V1\App\Zone\ZoneMobileService;
use App\Http\Services\Api\V1\App\Unit\UnitService;
use App\Http\Services\Api\V1\App\Unit\UnitWebService;
use App\Http\Services\Api\V1\App\Unit\UnitMobileService;
use App\Http\Services\Api\V1\App\Chat\ChatService;
use App\Http\Services\Api\V1\App\Chat\ChatWebService;
use App\Http\Services\Api\V1\App\Chat\ChatMobileService;
use App\Http\Services\Api\V1\App\Info\InfoService;
use App\Http\Services\Api\V1\App\Info\InfoWebService;
use App\Http\Services\Api\V1\App\Info\InfoMobileService;
use App\Http\Services\Api\V1\App\Social\SocialService;
use App\Http\Services\Api\V1\App\Social\SocialWebService;
use App\Http\Services\Api\V1\App\Social\SocialMobileService;
use App\Http\Services\Api\V1\App\CustomerReview\CustomerReviewService;
use App\Http\Services\Api\V1\App\CustomerReview\CustomerReviewWebService;
use App\Http\Services\Api\V1\App\CustomerReview\CustomerReviewMobileService;
use App\Http\Services\Api\V1\App\Complaint\ComplaintService;
use App\Http\Services\Api\V1\App\Complaint\ComplaintWebService;
use App\Http\Services\Api\V1\App\Complaint\ComplaintMobileService;
use App\Http\Services\Api\V1\App\Package\PackageService;
use App\Http\Services\Api\V1\App\Package\PackageWebService;
use App\Http\Services\Api\V1\App\Package\PackageMobileService;

use App\Http\Services\Api\V1\App\Notification\NotificationService;
use App\Http\Services\Api\V1\App\Notification\NotificationWebService;
use App\Http\Services\Api\V1\App\Notification\NotificationMobileService;

class PlatformServiceProvider extends ServiceProvider
{
    private const VERSIONS = [1];
    private const PLATFORMS = ['website', 'mobile'];
    private const DEFAULT_VERSION = 1;
    private const DEFAULT_PLATFORM = 'website';
    private const SERVICES = [
        1 => [
            AuthService::class => [
                AuthWebService::class,
                AuthMobileService::class
            ],
            BlogService::class => [
                BlogWebService::class,
                BlogMobileService::class
            ],
            CategoryService::class => [
                CategoryWebService::class,
                CategoryMobileService::class
            ],
            ContactUsService::class => [
                ContactUsWebService::class,
                ContactUsMobileService::class
            ],
            OrderService::class => [
                OrderWebService::class,
                OrderMobileService::class
            ],
            AuthAppService::class => [
                AuthAppWebService::class,
                AuthAppMobileService::class,
            ],
            CityService::class => [
                CityWebService::class,
                CityMobileService::class,
            ],
            UserService::class => [
                UserWebService::class,
                UserMobileService::class,
            ],
            UserHomeService::class => [
                UserHomeWebService::class,
                UserHomeMobileService::class,
            ],
            QuestionService::class => [
                QuestionWebService::class,
                QuestionMobileService::class,
            ],
            CommentService::class => [
                CommentWebService::class,
                CommentMobileService::class,
            ],
            OfferService::class => [
                OfferWebService::class,
                OfferMobileService::class,
            ],
            WalletService::class => [
                WalletWebService::class,
                WalletMobileService::class,
            ],
            GovernorateService::class => [
                GovernorateWebService::class,
                GovernorateMobileService::class,
            ],
            ZoneService::class => [
                ZoneWebService::class,
                ZoneMobileService::class,
            ],
            UnitService::class => [
                UnitWebService::class,
                UnitMobileService::class,
            ],
            ChatService::class => [
                ChatWebService::class,
                ChatMobileService::class,
            ],
            InfoService::class => [
                InfoWebService::class,
                InfoMobileService::class,
            ],
            SocialService::class => [
                SocialWebService::class,
                SocialMobileService::class,
            ],
            NegotiatesService::class => [
                NegotiatesWebService::class,
                NegotiatesMobileService::class,
            ],
            CustomerReviewService::class => [
                CustomerReviewWebService::class,
                CustomerReviewMobileService::class,
            ],
            ComplaintService::class => [
                ComplaintWebService::class,
                ComplaintMobileService::class,
            ],
            PackageService::class => [
                PackageWebService::class,
                PackageMobileService::class,
            ],
            NotificationService::class => [
                NotificationWebService::class,
                NotificationMobileService::class,
            ],
        ],
    ];
    private ?int $version;
    private ?string $platform;

    public function __construct($app)
    {
        parent::__construct($app);

        foreach (self::VERSIONS as $version) {
            foreach (self::PLATFORMS as $platform) {
                $pattern = app()->isProduction()
                    ? "v$version/$platform/*"
                    : "api/v$version/$platform/*";

                if (request()->is($pattern)) {
                    $this->version = $version;
                    $this->platform = $platform;
                    return;
                }
            }
        }

        $this->version = self::DEFAULT_VERSION;
        $this->platform = self::DEFAULT_PLATFORM;
    }

    private function getTargetService(array $services)
    {
        foreach ($services as $service) {
            if ($service::platform() == $this->platform) {
                return $service;
            }
        }

        return $services[0];
    }

    private function initiate(): void
    {
        $services = self::SERVICES[$this->version] ?? [];

        foreach ($services as $abstractService => $targetServices) {
            $this->app->singleton($abstractService, $this->getTargetService($targetServices));
        }
    }

    public function register(): void
    {
        $this->initiate();

    }


    public function boot(): void
    {
        //
    }
}
