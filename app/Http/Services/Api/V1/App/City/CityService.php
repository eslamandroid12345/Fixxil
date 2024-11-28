<?php

namespace App\Http\Services\Api\V1\App\City;

use App\Http\Resources\V1\App\City\CitySearchResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\CityRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\City\CityResource;

abstract class CityService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly CityRepositoryInterface      $cityRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(CityResource::class, $this->cityRepository, 'getActiveCities');
    }

    public function getAllCitiesForGoverment($id)
    {
        return $this->getService->handle(CityResource::class, $this->cityRepository, 'getAllCitiesForGoverment',parameters: [$id]);
    }

    public function getAllCitiesForSearch()
    {
        return $this->getService->handle(CitySearchResource::class, $this->cityRepository, 'getAllCitiesForSearch');
    }

}
