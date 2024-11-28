<?php

namespace App\Http\Services\Api\V1\App\Auth;

use App\Http\Requests\Api\V1\App\Auth\SignUpRequest;
use App\Http\Requests\Api\V1\App\Auth\SignInRequest;
use App\Http\Resources\V1\App\User\UserResource;
use App\Http\Services\Api\V1\Dashboard\Auth\Otp\OtpService;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\CustomerNotification;
use App\Notifications\ProviderNotification;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\CityUserRepositoryInterface;
use App\Repository\SubCategoryUserRepositoryInterface;
use App\Repository\UserFixedServiceRepositoryInterface;
use App\Repository\UserServiceImageRepositoryInterface;
use App\Repository\UserTimeRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Repository\OtpRepositoryInterface;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class AuthAppService extends PlatformService
{
    use Responser, Notification;
    protected $twilio;

    public function __construct(
        protected readonly UserRepositoryInterface           $userRepository,
        private readonly CityUserRepositoryInterface         $cityuserRepository,
        private readonly SubCategoryUserRepositoryInterface  $subcategoryuserRepository,
        private readonly UserFixedServiceRepositoryInterface $userfixedserviceRepository,
        private readonly UserServiceImageRepositoryInterface $userserviceimageRepository,
        private readonly UserTimeRepositoryInterface         $usertimeRepository,
        private readonly ManagerRepositoryInterface          $managerRepository,
        private readonly WalletRepositoryInterface           $walletRepository,
        protected readonly OtpRepositoryInterface $otpRepository,
        private readonly FileManagerService                  $fileManagerService,
        private readonly OtpService                          $otpService,
    )
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only('name', 'type', 'email', 'phone', 'city_id', 'governorate_id', 'zone_id', 'address', 'national_id', 'about');
            $data = array_merge($data, ["password" => Hash::make($request->password)]);
            if ($request->hasFile('image')) {
                $data['image'] = $this->fileManagerService->handle("image", "user/images");
            }
            if ($request->hasFile('national_id_image')) {
                $data['national_id_image'] = $this->fileManagerService->handle("national_id_image", "user/images");
            }
            if ($request->hasFile('criminal_record_sheet')) {
                $data['criminal_record_sheet'] = $this->fileManagerService->handle("criminal_record_sheet", "user/images");
            }
            if ($request->national_id_image && $request->criminal_record_sheet) {
                $data['is_verified'] = true;
            }
            $user = $this->userRepository->create($data);
            if ($request->fcm) {
                $this->userRepository->update($user->id, ['fcm' => $request->fcm]);
            }
            $managers = $this->managerRepository->getAll();
            if ($user->type == "provider") {
                $this->userRepository->update($user->id, ['wallet' => 100]);
                $this->SendNotification(ProviderNotification::class, $managers, [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]);
            }
            if ($user->type == "customer") {
                $this->userRepository->update($user->id, ['is_active' => 1]);
                $this->SendNotification(CustomerNotification::class, $managers, [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]);
            }
            $this->userTime($user);
            $this->storeCity($request->cities, $user->id);
            $this->storeService($request->services, $user->id);
            if ($request->fixed_services && is_array($request->fixed_services)) {
                $this->storeFixedService($request->fixed_services, $user->id);
            }

            $this->storeServiceImage($request->services_images, $user->id);
            $credentials = $request->only('phone', 'password');
            auth('api-app')->attempt($credentials);
            if ($user->type == "customer")
            {
                // $this->otpService->generate(auth('api-app')->user());
                $this->otpService->generateCreate(auth('api-app')->user());
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new UserResource($user, true));
        } catch (Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function storeCity($cities, $user_id)
    {
        if (is_array($cities)) {
            foreach ($cities as $city) {
                $this->cityuserRepository->create(['city_id' => $city, 'user_id' => $user_id]);
            }
        }
    }

    public function storeService($services, $user_id)
    {
        if (is_array($services)) {
            foreach ($services as $service) {
                $this->subcategoryuserRepository->create(['sub_category_id' => $service, 'user_id' => $user_id]);
            }
        }
    }

    public function storeFixedService($fixedservices, $user_id)
    {
        if (is_array($fixedservices)) {
            foreach ($fixedservices as $fixeddservice) {
                $this->userfixedserviceRepository->create(['name' => $fixeddservice['name'], 'price' => $fixeddservice['price'], 'unit_id' => $fixeddservice['unit_id'], 'user_id' => $user_id]);
            }
        }
    }

    public function storeServiceImage($servicesimages, $user_id)
    {
        if (is_array($servicesimages)) {
            foreach ($servicesimages as $index => $image) {
                $newImage = $this->fileManagerService->handle("services_images.$index", "user/images");
                $this->userserviceimageRepository->create(['image' => $newImage, 'user_id' => $user_id]);
            }
        }
    }

    public function userTime($user)
    {
        if ($user->type == "provider") {
            $daysOfWeeks = [
                'Sunday' => ['ar' => 'الأحد', 'en' => 'Sunday', 'index' => '7'],
                'Monday' => ['ar' => 'الاثنين', 'en' => 'Monday', 'index' => '1'],
                'Tuesday' => ['ar' => 'الثلاثاء', 'en' => 'Tuesday', 'index' => '2'],
                'Wednesday' => ['ar' => 'الأربعاء', 'en' => 'Wednesday', 'index' => '3'],
                'Thursday' => ['ar' => 'الخميس', 'en' => 'Thursday', 'index' => '4'],
                'Friday' => ['ar' => 'الجمعة', 'en' => 'Friday', 'index' => '5'],
                'Saturday' => ['ar' => 'السبت', 'en' => 'Saturday', 'index' => '6'],
            ];
            foreach ($daysOfWeeks as $day => $translations) {
                $this->usertimeRepository->create([
                    'user_id' => $user->id,
                    'day_ar' => $translations['ar'],
                    'day_en' => $translations['en'],
                    'day_index' => $translations['index'],
                    'from' => '09:00',
                    'to' => '17:00'
                ]);
            }
        }
    }

    public function signOut()
    {
        auth('api-app')->user()?->update(['fcm' => null]);
        auth('api-app')->logout();
        return $this->responseSuccess(message: __('messages.Successfully loggedOut'));
    }

    public function reset($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('phone',$request->phone);
            if($user)
            {
                $randomNumber = random_int(1000, 9999);

                $phone = '+2' . $user->phone;
                $this->sendSms($phone, 'Your OTP From Fixxil To Reset Password is: ' . $randomNumber);

                $this->userRepository->update($user->id,['reset' => null]);
                $this->userRepository->update($user->id,['reset' => $randomNumber]);
                return $this->responseSuccess(message: __('dashboard.reset_sent_successfully'));
            }
            else
            {
                return $this->responseFail(status: 422, message: __('dashboard.reset_not_sent_successfully'));
            }
        }
        catch (\Exception $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function sendSms($to, $message)
    {
        $this->twilio->messages->create(
            $to,
            [
                'from' => '+16193321344',
                'body' => $message,
            ]
        );
    }

    public function resetUserconfirm($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('reset',$request->confirm);
            if($user)
            {
                return $this->responseSuccess(message: __('dashboard.code_Is_Confirm'));
            }
            else
            {
                return $this->responseFail(status: 422, message: __('dashboard.code_Not_Confirm'));
            }
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function changePassword($request)
    {
        try
        {
            $user = $this->userRepository->checkItem('phone',$request->phone);
            if($user)
            {
                $this->userRepository->update($user->id,['password' => Hash::make($request->newpassword)]);
                $this->userRepository->update($user->id,['reset' => null]);
                return $this->responseSuccess(message: __('dashboard.password_Is_Changed'));
            }
            return $this->responseFail(status: 422, message: __('dashboard.User_Not_Found'));
        }
        catch (\Exception  $e)
        {
            return response()->json($e->getMessage(), 422);
        }
    }

}
