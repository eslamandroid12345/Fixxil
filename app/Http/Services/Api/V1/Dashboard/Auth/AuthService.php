<?php

namespace App\Http\Services\Api\V1\Dashboard\Auth;

use App\Http\Requests\Api\V1\Dashboard\Auth\SignInRequest;
use App\Http\Resources\V1\Dashboard\Governorate\OneGovernorateResource;
use App\Http\Resources\V1\Dashboard\Manager\ManagerResource;
use App\Http\Resources\V1\User\UserResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Resources\V1\Dashboard\Manager\AdminProfileResource;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\ManagerRepositoryInterface;
use App\Http\Requests\Api\V1\Dashboard\Profile\ProfileRequest;

abstract class AuthService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly ManagerRepositoryInterface $managerRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function signIn(SignInRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth('api-manager')->attempt($credentials);
        if ($token) {
            return $this->responseSuccess(message: __('messages.Successfully authenticated'), data: new ManagerResource(auth('api-manager')->user(), true));
        }

        return $this->responseFail(status: 401, message: __('messages.wrong credentials'));
    }

    public function signOut()
    {
        auth('api-manager')->logout();
        return $this->responseSuccess(message: __('messages.Successfully loggedOut'));
    }

    public function getProfile()
    {
        return $this->getService->handle(AdminProfileResource::class, $this->managerRepository, method: 'getById', parameters: [auth('api-manager')->user()->id], is_instance: true);
    }

    public function updateProfile(ProfileRequest $request)
    {
        try
        {
            $manager = $this->managerRepository->getById(auth('api-manager')->user()->id);
            $data = $request->validated();
            if ($request->hasFile('image'))
            {
                $data['image'] = $this->fileManagerService->handle("image", "manager/images", $manager->getRawOriginal('image'));
            }
            $this->managerRepository->update($manager->id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
