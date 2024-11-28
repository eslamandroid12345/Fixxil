<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Changes;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Changes\ChangesService;
use Illuminate\Http\Request;

class ChangesController extends Controller
{
    public function __construct(
        private readonly ChangesService $service
    )
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:changes-read')->only('index' , 'show');
        $this->middleware('permission:changes-update')->only('approve','reject');
    }
    public function index()
    {
        return $this->service->index();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }
    public function approve($id)
    {
        return $this->service->approve($id);
    }
    public function reject($id)
    {
        return $this->service->reject($id);
    }
}
