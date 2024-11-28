<?php

namespace App\Http\Services\Api\V1\App\Package;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\PackageRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Package\PackageResource;

abstract class PackageService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly PackageRepositoryInterface    $packageRepository,
        private readonly GetService                     $getService,
    )
    {
    }

    public function getAllPackages()
    {
        return $this->getService->handle(PackageResource::class, $this->packageRepository, 'getAllPackages');
    }


}
