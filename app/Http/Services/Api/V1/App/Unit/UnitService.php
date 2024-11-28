<?php

namespace App\Http\Services\Api\V1\App\Unit;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\UnitRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Unit\UnitResource;

abstract class UnitService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly UnitRepositoryInterface      $unitRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(UnitResource::class, $this->unitRepository, 'getActive');
    }

}
