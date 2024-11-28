<?php

namespace App\Http\Services\Api\V1\App\Info;

use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\InfoRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Info\InfoResource;

abstract class InfoService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly InfoRepositoryInterface   $infoRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly GetService                   $getService,
    )
    {
    }

    public function getInfo()
    {
//        return $this->getService->handle(InfoResource::class, $this->infoRepository);
        $data = $this->infoRepository->getAll();
        $result = [];
        foreach ($data as $item)
        {
//            return $item;
            if($item['type'] =='image')
            {
                $result[$item['key']] = url($item['value']);
            }
            else
            {
                $result[$item['key']] = $item['value'];
            }
        }
        return $this->responseSuccess(data: $result);
    }

}
