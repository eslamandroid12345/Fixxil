<?php

namespace App\Http\Controllers\Api\V1\App\User;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\UserHome\UserHomeService;
use http\Env\Request;
use App\Http\Requests\Api\V1\App\User\UserSearchRequest;

class UserHomeController extends Controller
{
    public function __construct(
        private readonly UserHomeService $user,
    )
    {
//        $this->middleware('auth:api-app');
    }

    public function getAllUsersBySubCategory($id)
    {
        return $this->user->getAllUsersBySubCategory($id);
    }

    public function getOneUserBySubCategory($subcategory_id,$id)
    {
        return $this->user->getOneUserBySubCategory($subcategory_id,$id);
    }
    public function getOneUser($id)
    {
        return $this->user->getOneUser($id);
    }

    public function search(UserSearchRequest $request)
    {
        return $this->user->search($request);
    }

}
