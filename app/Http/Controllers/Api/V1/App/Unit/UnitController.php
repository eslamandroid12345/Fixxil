<?php

namespace App\Http\Controllers\Api\V1\App\Unit;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Unit\UnitService;

class UnitController extends Controller
{
    public function __construct(
        private readonly UnitService $unit,
    )
    {
    }

    public function index()
    {
        return $this->unit->index();
    }
}
