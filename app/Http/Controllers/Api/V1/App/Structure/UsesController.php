<?php

namespace App\Http\Controllers\Api\V1\App\Structure;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\App\UseCategory\UseCategoryResource;
use App\Http\Services\Mutual\GetService;
use App\Repository\UseCategoryRepositoryInterface;
use Illuminate\Http\Request;

class UsesController extends Controller
{
    public function __construct(
        private GetService $get ,
        private UseCategoryRepositoryInterface $repository ,
    )
    {
    }
    
    public function index()
    {
        return $this->get->handle(UseCategoryResource::class,$this->repository,'getAllUseCategories');
    }
}
