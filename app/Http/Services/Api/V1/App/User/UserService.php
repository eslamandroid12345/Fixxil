<?php

namespace App\Http\Services\Api\V1\App\User;

use App\Http\Enums\ChangeTypeEnum;
use App\Http\Requests\Api\V1\App\User\UserMainDataRequest;
use App\Http\Requests\Api\V1\App\User\UserServiceRequest;
use App\Http\Requests\Api\V1\App\User\UserTimeRequest;
use App\Http\Resources\V1\App\Category\CategoryProfileResource;
use App\Http\Resources\V1\App\Governorate\GovernorateProfileResource;
use App\Http\Requests\Api\V1\App\User\StoreImageRequest;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Models\Category;
use App\Models\SubCategory;
use App\Notifications\UpdateUserDataNotification;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\ChangeRepositoryInterface;
use App\Repository\CityUserRepositoryInterface;
use App\Repository\GovernorateRepositoryInterface;
use App\Repository\Eloquent\Repository;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\SubCategoryUserRepositoryInterface;
use App\Repository\UserFixedServiceRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\UserServiceImageRepositoryInterface;
use App\Repository\UserTimeRepositoryInterface;
use App\Repository\OtpRepositoryInterface;
use Carbon\Carbon;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\User\UserProfileResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

abstract class UserService extends PlatformService
{
    use Responser, Notification;

    protected $twilio;

    public function __construct(
        private readonly UserRepositoryInterface             $userRepository,
        private readonly ManagerRepositoryInterface          $managerRepository,
        private readonly ChangeRepositoryInterface           $changeRepository,
        private readonly CityUserRepositoryInterface         $cityuserRepository,
        private readonly SubCategoryUserRepositoryInterface  $subcategoryuserRepository,
        private readonly CategoryRepositoryInterface         $categoryRepository,
        private readonly GovernorateRepositoryInterface      $governorateRepository,
        private readonly UserFixedServiceRepositoryInterface $userfixedserviceRepository,
        private readonly UserServiceImageRepositoryInterface $userserviceimageRepository,
        private readonly UserTimeRepositoryInterface         $usertimeRepository,
        private readonly OtpRepositoryInterface $otpRepository,
        private readonly FileManagerService                  $fileManagerService,
        private readonly GetService                          $getService,
    )
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function getDetails()
    {
        $categories = CategoryProfileResource::collection($this->categoryRepository->getAllMainCateogries());
        $governorates = GovernorateProfileResource::collection($this->governorateRepository->getAll(relations: ['cities']));
        $user = UserProfileResource::make($this->userRepository->getProfile());
        return $this->responseSuccess(data: [
            'user' => $user,
            'categories' => $categories,
            'governorates' => $governorates,
        ]);
    }

    public function updateMainData(UserMainDataRequest $request)
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            $relationalData = $request->only('city_id', 'governorate_id', 'zone_id');
            // if ($request->hasFile('image'))
            if ($request->image !== null)
            {
                $image = $this->fileManagerService->handle("image", "user/images", $user->getRawOriginal('image'));
                $data['image'] = url($image);
            }
            else
            {
                $image = $user->image;
            }
            if ($request->has('password') && $request->password != null) {
                $relationalData['password'] = $request->password;
            } else {
                unset($relationalData['password']);
            }

            if ($request->has('national_id') && $request->national_id != null) {
                $data['national_id'] = $request->national_id;
            } else {
                unset($relationalData['national_id']);
            }


            $newData = $request->only(['name', 'email', 'phone', 'address', 'about']);
            $newData['image'] = url($image);

            $this->userRepository->update($id, $relationalData);
            $this->pendingChanges($user, $newData);
            $newuser = $this->userRepository->getById($id);
            return $this->responseSuccess(message: __('messages.The data has been sent successfully and is awaiting review by the administration.'), data: new UserProfileResource($newuser));
        } catch (\Exception $e) {
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function notifyManagers($change)
    {
        $managers = $this->managerRepository->getAll();
        $this->SendNotification(UpdateUserDataNotification::class, $managers, [
            'change_id' => $change->id,
            'type' => $change->type
        ]);
    }

    private function pendingChanges($user, $newData)
    {
        $user->mainDataChanges()?->delete();
        $change = $user->mainDataChanges()?->create([
            'data' => json_encode($newData),
            'type' => ChangeTypeEnum::MAIN_DETAILS->value
        ]);
        $this->notifyManagers($change);
    }

    public function updateServiceData(UserServiceRequest $request)
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            if ($request->services && is_array($request->services)) {
                $user->subCategories()->sync($request->services);
            }
            if ($request->cities && is_array($request->cities)) {
                $user->cities()->sync($request->cities);
            }
            if ($request->fixed_services && is_array($request->fixed_services)) {
                $user->fixedServices()->delete();
                foreach ($request->fixed_services as $fixeddservice) {
                    $this->userfixedserviceRepository->create(['name' => $fixeddservice['name'], 'unit_id' => $fixeddservice['unit_id'], 'price' => $fixeddservice['price'], 'user_id' => $user->id]);
                }
            }

            if ($request->services_images && is_array($request->services_images)) {
                $this->pendingImages($request->services_images, $user);
                return $this->responseSuccess(message: __('messages.The data has been sent successfully and is awaiting review by the administration.'));
            }
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function pendingImages($images, $user)
    {
        $user->serviceImagesChanges()?->delete();
        foreach ($images as $index => $image) {
            $imagesPaths[]['path'] = $this->fileManagerService->handle("services_images.$index", "user/images");
        }
        $change = $user->mainDataChanges()?->create([
            'data' => json_encode($imagesPaths),
            'type' => ChangeTypeEnum::SERVICE_IMAGES->value
        ]);
        $this->notifyManagers($change);
    }

    public function updateTime(UserTimeRequest $request)
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            if ($request->user_times) {
                foreach ($request->user_times as $user_time) {
                    $usertime = $this->usertimeRepository->getTimeForUser($id, $user_time['day']);
                    $this->usertimeRepository->update($usertime->id, ['from' => $user_time['from'], 'to' => $user_time['to']]);
                }
            }
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function updateActive()
    {
        $id = auth('api-app')->id();
        $user = $this->userRepository->getById($id);
        $this->userRepository->update($user->id, ['last_seen' => Carbon::now()]);
        return $this->responseSuccess(message: __('messages.updated successfully'));
    }

    public function deleteImage($id)
    {
        $this->userserviceimageRepository->delete($id);
        return $this->responseSuccess(message: __('messages.deleted successfully'));
    }

    public function storeImage(StoreImageRequest $request)
    {
        $user = $this->userRepository->getById(auth('api-app')->id());
        $newImage = $this->fileManagerService->handle("image", "user/images");
        $this->userserviceimageRepository->create(['image' => $newImage, 'user_id' => $user->id]);
        return $this->responseSuccess(message: __('messages.created successfully'));
    }

    public function times($request)
    {
        try {
            $available = [];
            $day = $this->usertimeRepository->getFromToForDay($request->provider_id, $request->day);
            if ($day?->getRawOriginal('to') === null || $day?->getRawOriginal('from') === null)
                return $this->responseSuccess(data: $available);
            $from = Carbon::createFromFormat('H:i:s', $day->from); // 24-hour format
            $to = Carbon::createFromFormat('H:i:s', $day->to); // 24-hour format
            if ($to->lessThan($from))
                $to->addDay();
            while ($from->lessThan($to)) {
                $available[] = $from->format('g:i a');
                $from->addHour();
            }
            return $this->responseSuccess(data: $available);
        } catch (\Exception $e) {
            Log::error('USER Times  Error :' . $e->getMessage());
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changePassword($request)
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            if (Hash::check($request->oldpassword, $user->password)) {
                $this->userRepository->update($user->id, ['password' => Hash::make($request->newpassword)]);
                return $this->responseSuccess(message: __('messages.updated successfully'));
            } else {
                return $this->responseFail(message: __('messages.old_password_is_not_correct'));
            }

        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changePhone($request)
    {
        try
        {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            if ($user)
            {
                $otp = $this->otpRepository->generateOtp($user);
                $this->otpRepository->update($otp->id, ['phone' => $request->phone]);
                $phone = '+2' . $request->phone;
                $this->sendSms($phone, 'Your OTP From Fixxil is: ' . $otp->otp);
                return $this->responseSuccess(message: __('messages.send_successfully'));
            }
            else
            {
                return $this->responseFail(message: __('messages.user_not_found'));
            }

        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function confirmPhone($request)
    {
        try
        {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            if ($user)
            {
                $check = $this->otpRepository->first('user_id',$user->id);
                if($check)
                {
                    $check_otp = $this->otpRepository->first('otp',$request->confirm);
                    if($check_otp)
                    {
                        $this->userRepository->update($user->id, ['phone' => $check_otp->phone]);
                        return $this->responseSuccess(message: __('messages.updated successfully'));
                    }
                    else
                    {
                        return $this->responseFail(status: 422, message: __('dashboard.code_Not_Confirm'));
                    }
                }
                else
                {
                    return $this->responseFail(message: __('messages.user_not_found'));
                }
            }
            else
            {
                return $this->responseFail(message: __('messages.user_not_found'));
            }

        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
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

    public function storeDocumentation($request)
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            $data = $request->only('national_id');

            if ($request->hasFile('criminal_record_sheet')) {
                $image = $this->fileManagerService->handle("criminal_record_sheet", "user/images", $user->getRawOriginal('criminal_record_sheet'));
                $data['criminal_record_sheet'] = $image;
            } else {
                unset($data['criminal_record_sheet']);
            }

            if ($request->hasFile('national_id_image')) {
                $image = $this->fileManagerService->handle("national_id_image", "user/images", $user->getRawOriginal('national_id_image'));
                $data['national_id_image'] = $image;
            } else {
                unset($data['national_id_image']);
            }

            $this->userRepository->update($user->id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteAccount()
    {
        try {
            $id = auth('api-app')->id();
            $user = $this->userRepository->getById($id);
            auth('api-app')->logout();
            $this->userRepository->delete($user->id);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
