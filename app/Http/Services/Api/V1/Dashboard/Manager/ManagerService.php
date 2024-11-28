<?php

namespace App\Http\Services\Api\V1\Dashboard\Manager;

use App\Http\Requests\Api\V1\Dashboard\Manager\ManagerRequest;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\Manager\AdminResource;
use App\Http\Resources\V1\Dashboard\Manager\AdminCollection;
use Illuminate\Support\Facades\Hash;

class ManagerService
{
    use Responser;

    public function __construct(
        private readonly ManagerRepositoryInterface $managerRepository,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly GetService                  $getService,
        private readonly FileManagerService          $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(AdminCollection::class, $this->managerRepository,method: 'paginate',is_instance: true);
    }

    public function store(ManagerRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->except(['role','password_confirmation']);
            $data['is_active'] = $request->is_active ? true : false;
            $data = array_merge($data, ["password" => Hash::make($request->password)]);
            if ($request->hasFile('image'))
            {
                $data['image'] = $this->fileManagerService->handle("image", "admin/images");
            }
            $admin = $this->managerRepository->create($data);
            $role = $this->roleRepository->getById($request->role);
            $admin->assignRole($role);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'), data: new AdminResource($admin));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id)
    {
        return $this->getService->handle(AdminResource::class, $this->managerRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function update(ManagerRequest $request, $id)
    {
        try
        {
            $admin = $this->managerRepository->getById($id);
            $data = $request->except(['role','password_confirmation']);
            $data['is_active'] = $request->is_active ? true : false;
            if($request->password)
            {
                $data = array_merge($data, ["password" => Hash::make($request->password)]);
            }
            if ($request->hasFile('image'))
            {
                $data['image'] = $this->fileManagerService->handle("image", "admin/images");
            }
            $this->managerRepository->update($admin->id, $data);
            $roles = $admin->roles;
            foreach ($roles as $role)
            {
                $admin->removeRole($role->name);
            }
            $role = $this->roleRepository->getById($request->role);
            $admin->assignRole($role);
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
            $this->managerRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request,$id)
    {
        try
        {
            $manager = $this->managerRepository->getById($id);
            $data['is_active'] = $request->is_active ? true : false;
            $this->managerRepository->update($id, $data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
