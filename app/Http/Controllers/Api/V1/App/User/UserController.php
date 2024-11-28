<?php

namespace App\Http\Controllers\Api\V1\App\User;

use App\Http\Requests\Api\V1\App\User\UserMainDataRequest;
use App\Http\Requests\Api\V1\App\User\UserServiceRequest;
use App\Http\Requests\Api\V1\App\User\UserTimeRequest;
use App\Http\Requests\Api\V1\App\User\StoreImageRequest;
use App\Http\Requests\Api\V1\App\User\ChangePasswordRequest;
use App\Http\Requests\Api\V1\App\User\ChangePhoneRequest;
use App\Http\Requests\Api\V1\App\User\ConfirmPhoneRequest;
use App\Http\Requests\Api\V1\App\User\DocumentationRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\User\UserTimesAvailable;
use App\Http\Services\Api\V1\App\User\UserService;
use http\Env\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $user,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function getDetails()
    {
        return $this->user->getDetails();
    }

    public function updateMainData(UserMainDataRequest $request)
    {
        return $this->user->updateMainData($request);
    }

    public function updateServiceData(UserServiceRequest $request)
    {
        return $this->user->updateServiceData($request);
    }

    public function updateTime(UserTimeRequest $request)
    {
        return $this->user->updateTime($request);
    }

    public function updateActive()
    {
        return $this->user->updateActive();
    }

    public function deleteImage($id)
    {
        return $this->user->deleteImage($id);
    }

    public function storeImage(StoreImageRequest $request)
    {
        return $this->user->storeImage($request);
    }

    public function times(UserTimesAvailable $request)
    {
        return $this->user->times($request);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->user->changePassword($request);
    }

    public function changePhone(ChangePhoneRequest $request)
    {
        return $this->user->changePhone($request);
    }

    public function confirmPhone(ConfirmPhoneRequest $request)
    {
        return $this->user->confirmPhone($request);
    }

    public function storeDocumentation(DocumentationRequest $request)
    {
        return $this->user->storeDocumentation($request);
    }
    public function deleteAccount()
    {
        return $this->user->deleteAccount();
    }
}
