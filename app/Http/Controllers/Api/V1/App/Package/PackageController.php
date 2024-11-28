<?php

namespace App\Http\Controllers\Api\V1\App\Package;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Package\PackageService;

class PackageController extends Controller
{
    public function __construct(
        private readonly PackageService $package,
    )
    {
    }

    public function getAllPackages()
    {
        return $this->package->getAllPackages();
    }


}
