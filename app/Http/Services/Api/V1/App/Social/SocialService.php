<?php

namespace App\Http\Services\Api\V1\App\Social;

use App\Http\Resources\V1\App\User\UserResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\CustomerNotification;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Setting\SettingResource;
use App\Http\Requests\Api\V1\App\Social\SocialRequest;

abstract class SocialService extends PlatformService
{
    use GeneralTrait, Notification;
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface    $userRepository,
        private readonly FileManagerService         $fileManagerService,
        private readonly ManagerRepositoryInterface $managerRepository,
        private readonly GetService                 $getService,
    )
    {
    }

    public function redirect($provider)
    {
        $link = Socialite::with($provider)->stateless()->redirect()->getTargetUrl();
        return $this->returnData('data', $link);
    }

    public function callback($provider)
    {
        $userSocial = Socialite::with($provider)->stateless()->user();
        $user = $this->userRepository->first('email',$userSocial->getEmail());
        if ($user)
        {
            // return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource($user, true));
            $url = env('call_back_url');
            return redirect()->to($url . '?token=' . $user->token() . '&type=' . $user->type);
        }
        else
        {
            $user = $this->userRepository->create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'image' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
                'is_active' => true,
                'type' => 'customer',
            ]);
            $this->sendNewCustomerNotificaion($user);
            // return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource($user, true));
            $url = env('call_back_url');
            return redirect()->to($url . '?token=' . $user->token() . '&type=' . $user->type);
        }
    }

    public function callbackmobile(SocialRequest $request)
    {
        $user = $this->userRepository->first('email', $request->email);
        if ($user) {
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource($user, true));
        } else {
            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $request->image,
                'provider_id' => $request->provider_id,
                'provider' => $request->provider,
                'type' => 'customer',
                'is_active' => true,
                'fcm' => $request->fcm
            ]);
            $this->sendNewCustomerNotificaion($user);
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource($user, true));
        }
    }

    private function sendNewCustomerNotificaion($user)
    {
        $managers = $this->managerRepository->getAll(['id']);
        $this->SendNotification(CustomerNotification::class, $managers, [
            'user_name' => $user->name,
            'user_id' => $user->id,
        ]);
    }
}
