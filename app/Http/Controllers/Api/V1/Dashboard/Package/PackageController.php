<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Package\PackageRequest;
use App\Http\Services\Api\V1\Dashboard\Package\PackageService;

class PackageController extends Controller
{
    public function __construct(private readonly PackageService $package)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:package-read')->only('index' , 'show');
        $this->middleware('permission:package-create')->only('store');
        $this->middleware('permission:package-update')->only('update','changeStatus');
        $this->middleware('permission:package-delete')->only('destroy');
    }

    public function index()
    {
        return $this->package->index();
    }

    public function show($id)
    {
        return $this->package->show($id);
    }

    public function store(PackageRequest $request)
    {
        return $this->package->store($request);
    }

    public function update(PackageRequest $request, $id)
    {
        return $this->package->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->package->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->package->changeStatus($request,$id);
    }
}
