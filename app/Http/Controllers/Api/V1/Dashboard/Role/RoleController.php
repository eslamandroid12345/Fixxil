<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Role;
use App\Http\Requests\Api\V1\Dashboard\Role\RoleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Role\RoleService;

class RoleController extends Controller
{
    public function __construct(private readonly RoleService $role)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:role-read')->only('index' , 'show');
        $this->middleware('permission:role-create')->only('create', 'store');
        $this->middleware('permission:role-update')->only('edit' , 'update');
        $this->middleware('permission:role-delete')->only('destroy');
    }

    public function index()
    {
        return $this->role->index();
    }

    public function show($id)
    {
        return $this->role->show($id);
    }

    public function store(RoleRequest $request)
    {
        return $this->role->store($request);
    }

    public function update(RoleRequest $request, $id)
    {
        return $this->role->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->role->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->role->changeStatus($request,$id);
    }

    public function getAllRoles()
    {
        return $this->role->getAllRoles();
    }
}
