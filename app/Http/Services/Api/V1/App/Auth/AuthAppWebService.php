<?php

namespace App\Http\Services\Api\V1\App\Auth;

use App\Http\Requests\Api\V1\App\Auth\SignInRequest;
use App\Http\Resources\V1\App\User\UserResource;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;

class AuthAppWebService extends AuthAppService
{
    use Responser;


    public static function platform(): string
    {
        return 'website';
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('phone', 'password');
        // $user = $this->userRepository->first('phone', $request->phone);
        // $check = $this->otpRepository->first('user_id',$user->id);
        // if($check)
        // {
        //     return $this->responseFail(status: 422, message: __('messages.not_verified'));
        // }
        $credentials = array_merge($credentials, ['is_active' => 1]);
        $token = auth('api-app')->attempt($credentials);
        if ($token)
        {
            $user = $this->userRepository->getById(auth('api-app')->id());
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new UserResource(auth('api-app')->user(), true));
        }
        return $this->responseFail(status: 422, message: __('messages.wrong credentials'));
    }


}
