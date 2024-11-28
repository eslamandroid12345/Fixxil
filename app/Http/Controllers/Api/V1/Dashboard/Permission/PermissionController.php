<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Permission\PermissionService;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionService $permission)
    {
        $this->middleware('auth:api-manager');
//        $this->middleware('permission:role-read')->only('index' , 'show');
//        $this->middleware('permission:role-create')->only('create', 'store');
//        $this->middleware('permission:role-update')->only('edit' , 'update');
//        $this->middleware('permission:role-delete')->only('destroy');
    }

    public function index()
    {
        return $this->permission->index();
    }
}
