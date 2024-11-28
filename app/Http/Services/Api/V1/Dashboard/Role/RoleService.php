<?php

namespace App\Http\Services\Api\V1\Dashboard\Role;

use App\Http\Requests\Api\V1\Dashboard\Role\RoleRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\RoleRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Role\RoleResource;
use App\Http\Resources\V1\Dashboard\Role\RoleWithoutPaginateResource;
use App\Http\Resources\V1\Dashboard\Role\RoleCollection;

class RoleService
{
    use Responser;

    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly PermissionRepositoryInterface $permissionRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(RoleCollection::class, $this->roleRepository,method: 'paginate',is_instance: true);
    }

    public function store(RoleRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->validated();
            $role = $this->roleRepository->create($data);
            if($request->permissions)
            {
                $role->permissions()->detach();
                foreach($request->permissions as $permission)
                {
                    $per = $this->permissionRepository->getById($permission);
                    $role->givePermissionTo($per);
                }
            }
            else
            {
                $role->syncPermissions([]);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new RoleResource($role));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(RoleResource::class, $this->roleRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $role = $this->roleRepository->getById($id);
            $data = $request->validated();
            $this->roleRepository->update($role->id, $data);
            if($request->permissions)
            {
                $role->permissions()->detach();
                foreach($request->permissions as $permission)
                {
                    $per = $this->permissionRepository->getById($permission);
                    $role->givePermissionTo($per);
                }
            }
            else
            {
                $role->syncPermissions([]);
            }
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->roleRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getAllRoles()
    {
        return $this->getService->handle(RoleWithoutPaginateResource::class, $this->roleRepository);
    }
}
