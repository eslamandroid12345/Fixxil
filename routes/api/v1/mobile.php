<?php

use App\Http\Controllers\Api\V1\App\Auth\Otp\OtpController;
use App\Http\Controllers\Api\V1\App\Negotiates\NegotiatesController;
use App\Http\Controllers\Api\V1\App\Order\OrderController;
use App\Http\Controllers\Api\V1\App\ContactUs\ContactUsController;
use App\Http\Controllers\Api\V1\App\Auth\AuthController;
use App\Http\Controllers\Api\V1\App\Notification\NotificationController;
use App\Http\Controllers\Api\V1\App\Blog\BlogController;
use App\Http\Controllers\Api\V1\App\Category\CategoryController;
use App\Http\Controllers\Api\V1\App\City\CityController;
use App\Http\Controllers\Api\V1\App\Governorate\GovernorateController;
use App\Http\Controllers\Api\V1\App\Review\ReviewController;
use App\Http\Controllers\Api\V1\App\Structure\HomeController;
use App\Http\Controllers\Api\V1\App\Structure\SeoController;
use App\Http\Controllers\Api\V1\App\User\UserController;
use App\Http\Controllers\Api\V1\App\User\UserHomeController;
use App\Http\Controllers\Api\V1\App\Question\QuestionController;
use App\Http\Controllers\Api\V1\App\Comment\CommentController;
use App\Http\Controllers\Api\V1\App\Offer\OfferController;
use App\Http\Controllers\Api\V1\App\Wallet\WalletController;
use App\Http\Controllers\Api\V1\App\Unit\UnitController;
use App\Http\Controllers\Api\V1\App\Zone\ZoneController;
use App\Http\Controllers\Api\V1\App\Chat\ChatController;
use App\Http\Controllers\Api\V1\App\Info\InfoController;
use App\Http\Controllers\Api\V1\App\Structure\AboutUsController;
use App\Http\Controllers\Api\V1\App\Structure\PolicyController;
use App\Http\Controllers\Api\V1\App\Social\SocialController;
use App\Http\Controllers\Api\V1\App\Structure\InstructionOrderController;
use App\Http\Controllers\Api\V1\App\Structure\InstructionUserController;
use App\Http\Controllers\Api\V1\App\Complaint\ComplaintController;
use App\Http\Controllers\Api\V1\App\Package\PackageController;
use App\Http\Enums\UserType;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::group(['prefix' => 'up'], function () {
            Route::post('{user:type}', 'signUp')->whereIn('user', UserType::values());
        });
        Route::post('out', 'signOut');

        Route::post('/reset', 'reset');
        Route::post('/reset-confirm', 'resetUserConfirm');
        Route::post('/change-password', 'changePassword');
    });
    Route::group(['prefix' => 'otp', 'middleware' => ['auth:api-app']], function () {
        Route::post('/verify', [OtpController::class, 'verify']);
        Route::get('/', [OtpController::class, 'send']);
    });
});
Route::group(['prefix' => 'auth/login', 'controller' => SocialController::class], function () {
    Route::get('{provider}','redirect');
    Route::get('{provider}/callback','callback');
    Route::post('{provider}/callbackmobile','callbackmobile');
});
Route::group(['prefix' => 'profile'], function () {
    Route::group(['controller' => UserController::class], function () {
        Route::get('details', 'getDetails');
        Route::delete('delete', 'deleteAccount');
        Route::group(['prefix' => 'update'], function () {
            Route::group(['prefix' => 'user'], function () {
                Route::post('data', 'updateMainData');
                Route::post('changePassword', 'changePassword');
                Route::post('change-phone', 'changePhone');
                Route::post('confirm-phone', 'confirmPhone');
                Route::post('service', 'updateServiceData');
                Route::post('time', 'updateTime');
                Route::get('times', 'times');
                Route::get('updateActive', 'updateActive');

                Route::post('deleteImage/{id}', 'deleteImage');
                Route::post('storeImage', 'storeImage');
            });
        });
    });
});

Route::get('sub-categories', [CategoryController::class, 'getAllSubCategory']);

Route::get('categoriesHome', [CategoryController::class, 'categoriesHome']);
Route::get('categories', [CategoryController::class, 'index']);
Route::group(['middleware' => 'type:provider'], function () {
    Route::get('packages', [PackageController::class, 'getAllPackages']);
});
Route::get('notifications', [NotificationController::class,'getNotificationsForUser']);
Route::get('notifications/read', [NotificationController::class,'readNotificationsForUser']);
Route::get('notifications/delete', [NotificationController::class,'deleteNotificationsForUser']);
Route::get('notifications/{id}/read', [NotificationController::class,'readNotificationForUser']);

Route::apiResource('blogs', BlogController::class)->only(['store', 'index', 'show']);
Route::get('blog/questions', [BlogController::class, 'getAllBlogQuestions']);
Route::apiResource('comments', CommentController::class)->only('store', 'update', 'destroy');

Route::apiResource('governorate', GovernorateController::class)->only(['index']);
Route::apiResource('cities', CityController::class)->only(['index']);
Route::apiResource('units', UnitController::class)->only(['index']);
Route::get('cities/{id}', [CityController::class, 'getAllCitiesForGoverment']);
Route::apiResource('zones', ZoneController::class)->only(['index']);
Route::get('zones/{id}', [ZoneController::class, 'getAllZonesForCity']);

Route::post('contact-us', [ContactUsController::class, 'send']);

Route::group(['prefix' => 'orders', 'controller' => OrderController::class], function () {
    Route::post('request', 'request')->middleware('type:customer');
    Route::post('provider/request', 'requestProvider')->middleware('type:customer');
    Route::post('change-action', 'changeAction');
    Route::post('choose-offer', 'chooseOffer')->middleware('access:order_id');
    Route::get('/hasOffers', 'hasOffers');
    Route::get('/oneOrderHasOffer/{id}', 'oneOrderHasOffer');
    Route::get('/getOrderForUser', 'getOrderForUser');
    Route::get('{id}/cancel', 'cancelOrder');

    Route::get('{id}/show', 'showOneOrder');

    Route::group(['prefix' => 'customer', 'middleware' => 'type:customer'], function () {
        Route::get('/getOrders', 'getOrdersCustomer');
        Route::get('/oneNewOrder/{id}', 'getOneNewOrderCustomer');
    });

    Route::group(['prefix' => 'provider', 'middleware' => 'type:provider'], function () {
        Route::get('/home', 'home');
        Route::get('/getOrders', 'getOrders');
        Route::get('/oneNewOrder/{id}', 'getOneNewOrder');
        Route::get('/orderNotHavOffer', 'getOrderNotHavOffer');
    });
});
Route::group(['prefix' => 'negotiates', 'controller' => NegotiatesController::class,
    'middleware' => ['auth:api-app']], function () {
    Route::post('/', 'negotiate')->middleware('access:order_id');
});

Route::group(['prefix' => 'offers', 'middleware' => 'type:provider','controller' => OfferController::class], function () {
    Route::post('store', 'store')->middleware('access:order_id');
    Route::get('getAllOffers', 'getAllOffers');
});

Route::group(['prefix' => 'wallet', 'middleware' => 'type:provider', 'controller' => WalletController::class], function () {
    Route::group(['prefix' => 'provider'], function () {
        Route::get('getTotal', 'getTotal');
        Route::get('getPointDetails', 'getPointDetails');
        Route::post('charge', 'charge');
        Route::post('getTotalCharge', 'getTotalCharge');
        Route::get('getAllDeposit', 'getAllDeposit');
    });
});

Route::group(['prefix' => 'sub-category', 'controller' => UserHomeController::class], function () {
    Route::get('/allUsers/{id}', 'getAllUsersBySubCategory');
    Route::get('oneUser/{subcategory_id}/{id}', 'getOneUserBySubCategory');
    Route::get('oneUser/{id}', 'getOneUser');
});

Route::group(['prefix' => 'questions', 'controller' => QuestionController::class], function () {
    Route::get('/', 'index');
    Route::post('store', 'store');
});

Route::get('getInfo',[InfoController::class,'getInfo']);

Route::group(['prefix' => 'structures'], function () {
    Route::resource('about', AboutUsController::class)->only('index');
    Route::resource('policy', PolicyController::class)->only('index');
    Route::resource('order_instruction', InstructionOrderController::class)->only('index');
    Route::resource('user_instruction', InstructionUserController::class)->only('index');
    Route::resource('home', HomeController::class)->only('index');
    Route::resource('seo', SeoController::class)->only('index');
});

Route::group(['prefix' => 'chats', 'controller' => ChatController::class], function () {
    Route::post('provide', 'provide');
    Route::group(['prefix' => 'rooms'], function () {
//        Route::get('/', 'getRooms');
        Route::group(['prefix' => '{room:id}'], function () {
            Route::get('/', 'getMessages');
            Route::post('load', 'loadMoreMessages');
            Route::post('send', 'send');
            Route::put('read', 'read');
        });
    });
//    Route::group(['prefix' => 'go'], function () {
//        Route::put('online', 'goOnline');
//        Route::put('offline', 'goOffline');
//    });
});

Route::group(['prefix' => 'reviews', 'controller' => ReviewController::class],function (){
    Route::post('/update','update');
    Route::get('/customer','customerReviews');
    Route::get('/provider/{id}','providerReviews');
    Route::post('/','store');
});

Route::group(['prefix' => 'complaints', 'controller' => ComplaintController::class],function (){
    Route::post('/store','store');
    Route::get('/getAllOrdersComplaint','getAllOrdersComplaint');
});

//test
