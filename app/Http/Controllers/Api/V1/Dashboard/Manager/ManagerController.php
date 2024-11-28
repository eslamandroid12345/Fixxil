<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Manager;
use App\Http\Requests\Api\V1\Dashboard\Manager\ManagerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Manager\ManagerService;

class ManagerController extends Controller
{
    public function __construct(private readonly ManagerService $manager)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:manager-read')->only('index' , 'show');
        $this->middleware('permission:manager-create')->only('create', 'store');
        $this->middleware('permission:manager-update')->only('edit' , 'update');
        $this->middleware('permission:manager-delete')->only('destroy');
    }

    public function index()
    {
        return $this->manager->index();
    }

    public function show($id)
    {
        return $this->manager->show($id);
    }

    public function store(ManagerRequest $request)
    {
        return $this->manager->store($request);
    }

    public function update(ManagerRequest $request, $id)
    {
        return $this->manager->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->manager->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->manager->changeStatus($request,$id);
    }
}
