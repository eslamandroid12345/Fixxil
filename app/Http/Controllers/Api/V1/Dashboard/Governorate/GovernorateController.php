<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Governorate;
use App\Http\Requests\Api\V1\Dashboard\Governorate\GovernorateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Governorate\GovernorateService;

class GovernorateController extends Controller
{
    public function __construct(private readonly GovernorateService $governorate)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:governorate-read')->only('index' , 'show');
        $this->middleware('permission:governorate-create')->only('store');
        $this->middleware('permission:governorate-update')->only('update','changeStatus');
        $this->middleware('permission:governorate-delete')->only('destroy');
    }

    public function index()
    {
        return $this->governorate->index();
    }

    public function show($id)
    {
        return $this->governorate->show($id);
    }

    public function store(GovernorateRequest $request)
    {
        return $this->governorate->store($request);
    }

    public function update(GovernorateRequest $request, $id)
    {
        return $this->governorate->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->governorate->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->governorate->changeStatus($request,$id);
    }
}
