<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Auth\SignInRequest;
use App\Http\Services\Api\V1\Dashboard\Auth\AuthService;
use App\Http\Requests\Api\V1\Dashboard\Profile\ProfileRequest;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    )
    {
        $this->middleware('auth:api-manager')->only('signOut','getProfile','updateProfile');
    }

    public function signIn(SignInRequest $request)
    {
        return $this->auth->signIn($request);
    }

    public function signOut()
    {
        return $this->auth->signOut();
    }

    public function getProfile()
    {
        return $this->auth->getProfile();
    }

    public function updateProfile(ProfileRequest $request)
    {
        return $this->auth->updateProfile($request);
    }
}
