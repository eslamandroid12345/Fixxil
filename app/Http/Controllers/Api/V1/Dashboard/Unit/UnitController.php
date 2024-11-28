<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Unit\UnitRequest;
use App\Http\Services\Api\V1\Dashboard\Unit\UnitService;

class UnitController extends Controller
{
    public function __construct(private readonly UnitService $unit)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:unit-read')->only('index' , 'show');
        $this->middleware('permission:unit-create')->only('store');
        $this->middleware('permission:unit-update')->only('update','changeStatus');
        $this->middleware('permission:unit-delete')->only('destroy');
    }

    public function index()
    {
        return $this->unit->index();
    }

    public function show($id)
    {
        return $this->unit->show($id);
    }

    public function store(UnitRequest $request)
    {
        return $this->unit->store($request);
    }

    public function update(UnitRequest $request, $id)
    {
        return $this->unit->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->unit->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->unit->changeStatus($request,$id);
    }
}
