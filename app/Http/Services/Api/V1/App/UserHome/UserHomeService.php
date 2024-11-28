<?php

namespace App\Http\Services\Api\V1\App\UserHome;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\User\UserProfileResource;
use App\Http\Resources\V1\App\User\UserHomeResource;
use App\Http\Resources\V1\App\User\UserOneHomeResource;
use Illuminate\Support\Facades\Hash;

abstract class UserHomeService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly UserRepositoryInterface      $userRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function getAllUsersBySubCategory($id)
    {
        return $this->getService->handle(UserHomeResource::class, $this->userRepository, 'getAllUsersBySubCategory',parameters: [$id]);
    }

    public function getOneUserBySubCategory($subcategory_id,$id)
    {
        return $this->getService->handle(UserOneHomeResource::class, $this->userRepository, 'getUserBySubCategory',parameters: [$subcategory_id,$id],is_instance: true);
    }
    public function getOneUser($id)
    {
        return $this->getService->handle(UserOneHomeResource::class, $this->userRepository, 'getById',parameters: [$id],is_instance: true);
    }

    public function search($request)
    {
        return $this->getService->handle(UserHomeResource::class, $this->userRepository, 'getUserBySearch',parameters: [$request]);
    }

}
