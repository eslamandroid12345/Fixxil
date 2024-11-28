<?php

namespace App\Http\Controllers\Api\V1\Dashboard\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\User\UserService;
use App\Http\Requests\Api\V1\User\AddPointRequest;

class UserController extends Controller
{
    public function __construct(private readonly UserService $user)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:user-read')->only('index' , 'show');
        $this->middleware('permission:user-update')->only('changeStatus');
        $this->middleware('permission:user-delete')->only('destroy');
    }

    public function index()
    {
        return $this->user->index();
    }

    public function show($id)
    {
        return $this->user->show($id);
    }

    public function destroy($id)
    {
        return $this->user->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->user->changeStatus($request,$id);
    }

    public function deleteImage($id)
    {
        return $this->user->deleteImage($id);
    }

    public function increasePoint(AddPointRequest $request,$id)
    {
        return $this->user->increasePoint($request,$id);
    }

    public function decreasePoint(AddPointRequest $request,$id)
    {
        return $this->user->decreasePoint($request,$id);
    }
}
