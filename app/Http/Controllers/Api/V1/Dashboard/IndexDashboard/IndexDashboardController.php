<?php

namespace App\Http\Controllers\Api\V1\Dashboard\IndexDashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\IndexDashboard\IndexDashboardService;

class IndexDashboardController extends Controller
{
    public function __construct(private readonly IndexDashboardService $indexDashboard)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:dashboard')->only('index');
    }

    public function index()
    {
        return $this->indexDashboard->index();
    }
}
