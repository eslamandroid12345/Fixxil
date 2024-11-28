<?php

namespace App\Http\Services\Api\V1\Dashboard\Permission;

use App\Http\Requests\Api\V1\Dashboard\Role\RoleRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Role\PermissionResource;

class PermissionService
{
    use Responser;
    public function __construct(
        private readonly PermissionRepositoryInterface $permissionRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(PermissionResource::class, $this->permissionRepository);
    }
}
