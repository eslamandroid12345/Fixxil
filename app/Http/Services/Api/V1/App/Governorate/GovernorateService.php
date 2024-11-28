<?php

namespace App\Http\Services\Api\V1\App\Governorate;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\GovernorateRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Governorate\GovernorateResource;

abstract class GovernorateService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly GovernorateRepositoryInterface      $governorateRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(GovernorateResource::class, $this->governorateRepository, 'getActiveGovernorate');
    }

}
