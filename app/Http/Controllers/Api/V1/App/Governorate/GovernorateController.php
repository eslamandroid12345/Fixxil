<?php

namespace App\Http\Controllers\Api\V1\App\Governorate;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Governorate\GovernorateService;

class GovernorateController extends Controller
{
    public function __construct(
        private readonly GovernorateService $governorate,
    )
    {
    }

    public function index()
    {
        return $this->governorate->index();
    }
}
