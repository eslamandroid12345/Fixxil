<?php

namespace App\Http\Services\Api\V1\App\Auth;

use App\Http\Requests\Api\V1\App\Auth\SignInRequest;
use App\Http\Resources\V1\App\User\UserResource;
use App\Http\Services\Api\V1\Dashboard\Auth\Otp\OtpService;
use App\Http\Services\Mutual\FileManagerService;

use App\Repository\UserRepositoryInterface;
use App\Repository\UserServiceImageRepositoryInterface;
use App\Repository\UserTimeRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Http\Traits\Responser;

class AuthAppMobileService extends AuthAppService
{

    use Responser;

    public static function platform(): string
    {
        return 'mobile';
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('phone', 'password');
        $credentials = array_merge($credentials, ['is_active' => 1]);
        $token = auth('api-app')->attempt($credentials);
        if ($token)
        {
            $user = $this->userRepository->getById(auth('api-app')->id());
            if($request->fcm)
            {
                $this->userRepository->update($user->id,['fcm' => $request->fcm]);
            }
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource(auth('api-app')->user(), true));
        }
        return $this->responseFail(status: 401, message: __('messages.wrong credentials'));
    }
}
