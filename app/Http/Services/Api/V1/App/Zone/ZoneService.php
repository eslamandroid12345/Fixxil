<?php

namespace App\Http\Services\Api\V1\App\Zone;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\ZoneRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Zone\ZoneResource;

abstract class ZoneService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly ZoneRepositoryInterface      $zoneRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(ZoneResource::class, $this->zoneRepository, 'getActiveZones');
    }

    public function getAllZonesForCity($id)
    {
        return $this->getService->handle(ZoneResource::class, $this->zoneRepository, 'getAllZonesForCity',parameters: [$id]);
    }

}
