<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Uses;
use App\Http\Requests\Api\V1\Dashboard\Uses\UsesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Uses\UsesService;

class UsesController extends Controller
{
    public function __construct(private readonly UsesService $uses)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:uses-read')->only('index');
        $this->middleware('permission:uses-show')->only('show');
        $this->middleware('permission:uses-create')->only('store');
        $this->middleware('permission:uses-update')->only('update');
        $this->middleware('permission:uses-delete')->only('destroy');
    }

    public function index($usecategory_id)
    {
        return $this->uses->index($usecategory_id);
    }

    public function show($usecategory_id,$id)
    {
        return $this->uses->show($usecategory_id,$id);
    }

    public function store(UsesRequest $request,$usecategory_id)
    {
        return $this->uses->store($request,$usecategory_id);
    }

    public function update(UsesRequest $request, $usecategory_id,$id)
    {
        return $this->uses->update($request,$usecategory_id, $id);
    }

    public function destroy($usecategory_id,$id)
    {
        return $this->uses->destroy($usecategory_id,$id);
    }
}
