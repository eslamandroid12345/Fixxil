<?php

namespace App\Http\Controllers\Api\V1\App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Auth\SignInRequest;
use App\Http\Requests\Api\V1\App\Auth\SignUpRequest;
use App\Http\Requests\Api\V1\App\Auth\UserChangePasswordRequest;
use App\Http\Requests\Api\V1\App\Auth\UserConfirmRequest;
use App\Http\Requests\Api\V1\App\Auth\UserResetRequest;
use App\Http\Services\Api\V1\App\Auth\AuthAppService;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthAppService $auth,
    )
    {
    }

    public function signUp(SignUpRequest $request)
    {
        return $this->auth->signUp($request);
    }

    public function signIn(SignInRequest $request)
    {
        return $this->auth->signIn($request);
    }

    public function signOut()
    {
        return $this->auth->signOut();
    }

    public function reset(UserResetRequest $request)
    {
        return $this->auth->reset($request);
    }

    public function resetUserConfirm(UserConfirmRequest $request)
    {
        return $this->auth->resetUserConfirm($request);
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        return $this->auth->changePassword($request);
    }
}
