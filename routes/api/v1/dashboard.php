<?php

use App\Http\Controllers\Api\V1\Dashboard\Auth\AuthController;
use App\Http\Controllers\Api\V1\Dashboard\Changes\ChangesController;
use App\Http\Controllers\Api\V1\Dashboard\ChatRoomMessage\ChatRoomMessageController;
use App\Http\Controllers\Api\V1\Dashboard\CustomerReview\CustomerReviewController;
use App\Http\Controllers\Api\V1\Dashboard\Payment\PaymentController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\HomeController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\HowUseController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\MobileLinkController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\SeoController;
use App\Http\Controllers\Api\V1\Dashboard\Uses\UsesController;
use App\Http\Controllers\Api\V1\Dashboard\UsesQuestion\UsesQuestionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Dashboard\Category\CategoryController;
use App\Http\Controllers\Api\V1\Dashboard\BlogQuestion\BlogQuestionController;
use App\Http\Controllers\Api\V1\Dashboard\SubCategory\SubCategoryController;
use App\Http\Controllers\Api\V1\Dashboard\ContactUs\ContactUsController;
use App\Http\Controllers\Api\V1\Dashboard\City\CityController;
use App\Http\Controllers\Api\V1\Dashboard\Blog\BlogController;
use App\Http\Controllers\Api\V1\Dashboard\User\UserController;
use App\Http\Controllers\Api\V1\Dashboard\Order\OrderController;
use App\Http\Controllers\Api\V1\Dashboard\Question\QuestionController;
use App\Http\Controllers\Api\V1\Dashboard\Blog\BlogAdminController;
use App\Http\Controllers\Api\V1\Dashboard\Governorate\GovernorateController;
use App\Http\Controllers\Api\V1\Dashboard\Unit\UnitController;
use App\Http\Controllers\Api\V1\Dashboard\Zone\ZoneController;
use App\Http\Controllers\Api\V1\Dashboard\Manager\ManagerController;
use App\Http\Controllers\Api\V1\Dashboard\Role\RoleController;
use App\Http\Controllers\Api\V1\Dashboard\Permission\PermissionController;
use App\Http\Controllers\Api\V1\Dashboard\Info\InfoController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\AboutUsController;
use App\Http\Controllers\Api\V1\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\PolicyController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\InstructionOrderController;
use App\Http\Controllers\Api\V1\Dashboard\Structure\InstructionUserController;
use App\Http\Controllers\Api\V1\Dashboard\IndexDashboard\IndexDashboardController;
use App\Http\Controllers\Api\V1\Dashboard\Package\PackageController;
use App\Http\Controllers\Api\V1\Dashboard\Complaint\ComplaintController;
use App\Http\Controllers\Api\V1\Dashboard\UseCategory\UseCategoryController;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('out', 'signOut');
    });
    Route::get('profile', 'getProfile');
    Route::post('update/profile', 'updateProfile');
});
Route::post('/categories/{id}/change-status', [CategoryController::class,'changeStatus']);

Route::get('index/dashboard', [IndexDashboardController::class,'index']);

Route::apiResource('categories', CategoryController::class);
Route::apiResource('units', UnitController::class);
Route::post('/units/{id}/change-status', [UnitController::class,'changeStatus']);

Route::apiResource('sub-categories', SubCategoryController::class)->except('index');
Route::post('/sub-categories/{id}/change-status', [SubCategoryController::class,'changeStatus']);
Route::get('/getSubCategoriesByCategory/{id}', [SubCategoryController::class,'getSubCategoriesByCategory']);

Route::apiResource('contact-us', ContactUsController::class)->only('index', 'show', 'destroy');

Route::post('/blogs/{id}/change-status', [BlogController::class,'changeStatus']);
Route::delete('/blogs/comment/{id}', [BlogController::class,'deleteComment']);
Route::get('/comments', [BlogController::class,'getAllComments']);
Route::apiResource('blogs', BlogController::class)->only('index', 'show', 'destroy');

Route::apiResource('admins/blogs', BlogAdminController::class);
Route::get('admins/blogs/comment/{id}', [BlogAdminController::class,'getCommentForBlog']);
Route::post('/admins/blogs/{id}/change-status', [BlogAdminController::class,'changeStatus']);
Route::delete('/admins/blogs/comment/{id}', [BlogAdminController::class,'deleteComment']);

Route::delete('/admins/blogs/image/{id}', [BlogAdminController::class,'deleteImage']);
Route::post('/admins/blogs/image/{id}', [BlogAdminController::class,'storeImages']);

Route::apiResource('blogsquestions', BlogQuestionController::class)->only('index', 'show', 'destroy');
Route::post('/blogsquestions/{id}/change-status', [BlogQuestionController::class,'changeStatus']);

Route::apiResource('governorates', GovernorateController::class);
Route::get('changes/{id}/approve', [ChangesController::class,'approve']);
Route::get('changes/{id}/reject', [ChangesController::class,'reject']);
Route::apiResource('changes', ChangesController::class)->only(['show','index']);
Route::post('/governorates/{id}/change-status', [GovernorateController::class,'changeStatus']);

Route::apiResource('cities', CityController::class);
Route::post('/cities/{id}/change-status', [CityController::class,'changeStatus']);
Route::get('city/{id}', [CityController::class, 'getAllCitiesForGoverment']);

Route::apiResource('zones', ZoneController::class);
Route::post('/zones/{id}/change-status', [ZoneController::class,'changeStatus']);
Route::get('zone/{id}', [ZoneController::class, 'getAllZonesForCity']);

Route::get('notifications', [NotificationController::class,'readNotificationsForAdmin']);
Route::get('notifications/read', [NotificationController::class,'readNotificationsForAdmin']);
Route::get('notifications/{id}/read', [NotificationController::class,'readNotificationForAdmin']);


Route::apiResource('managers', ManagerController::class);
Route::post('/managers/{id}/change-status', [ManagerController::class,'changeStatus']);


Route::apiResource('roles', RoleController::class);
Route::get('getAllRoles', [RoleController::class,'getAllRoles']);
Route::apiResource('permissions', PermissionController::class)->only('index');

Route::apiResource('users', UserController::class)->only('index','show','destroy');
Route::post('/users/{id}/change-status', [UserController::class,'changeStatus']);
Route::delete('/users/image/{id}', [UserController::class,'deleteImage']);
Route::post('/users/{id}/increase-point', [UserController::class,'increasePoint']);
Route::post('/users/{id}/decrease-point', [UserController::class,'decreasePoint']);

Route::apiResource('orders', OrderController::class)->only('index','show','destroy');
Route::post('/orders/{id}/change-status', [OrderController::class,'changeStatus']);
Route::post('/orders/{id}/stop', [OrderController::class,'stop']);
Route::get('/orders/message/{id}', [OrderController::class,'getOrderMessage']);
Route::delete('messages/{id}', [ChatRoomMessageController::class,'destroy']);

Route::apiResource('questions', QuestionController::class);
Route::post('/questions/{id}/change-status', [QuestionController::class,'changeStatus']);

Route::apiResource('packages', PackageController::class);
Route::post('/packages/{id}/change-status', [PackageController::class,'changeStatus']);


Route::group(['prefix' => 'info', 'controller' => InfoController::class], function () {
    Route::get('show', 'show');
    Route::post('update', 'update');
});

Route::group(['prefix' => 'payments', 'controller' => PaymentController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
});

Route::group(['prefix' => 'structures'], function () {
    Route::resource('about', AboutUsController::class)->only('store','index');
    Route::resource('policy', PolicyController::class)->only('store','index');
    Route::resource('order_instruction', InstructionOrderController::class)->only('store','index');
    Route::resource('order_used', InstructionUserController::class)->only('store','index');
    Route::resource('home', HomeController::class)->only('store','index');
    Route::resource('how_use', HowUseController::class)->only('store','index');
    Route::resource('mobile_link', MobileLinkController::class)->only('store','index');
    Route::resource('seo', SeoController::class)->only('store','index');
});

Route::post('customer-reviews/{id}/update', [CustomerReviewController::class,'update']);
Route::apiResource('customer-reviews', CustomerReviewController::class);

Route::apiResource('use-categories', UseCategoryController::class);

Route::apiResource('{usecategory_id}/uses', UsesController::class);
Route::apiResource('{use_id}/questions', UsesQuestionController::class);

Route::apiResource('complaints', ComplaintController::class)->only('index','show','destroy');
Route::post('complaints/{id}/change-status', [ComplaintController::class,'changeStatus']);

