<?php

namespace App\Http\Services\Api\V1\Dashboard\Info;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\InfoRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Api\V1\Dashboard\Info\InfoRequest;
use App\Http\Resources\V1\Dashboard\Info\InfoResource;
use Illuminate\Support\Facades\DB;

class InfoService
{
    use Responser;
    use GeneralTrait;

    public function __construct(
        private readonly InfoRepositoryInterface $infoRepository,
        private readonly GetService                   $getService,
        private readonly FileManagerService           $fileManagerService
    )
    {
    }

    public function show()
    {
        $text = $this->infoRepository->getText();
        $images = $this->infoRepository->getImages();
        $data = [
                   'text' => InfoResource::collection($text),
                   'images' => InfoResource::collection($images),
            ];
        return $this->returnData('data', $data);
        return $this->getService->handle(InfoResource::class, $this->infoRepository, method: 'getText');
    }
    
    public function update(InfoRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $this->updateText($request->text);
            $this->updateImages($request->images);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function updateText($array)
    {
        foreach ($array as $key => $value)
        {
            $this->infoRepository->updateValues($key,$value);
        }
    }

    public function updateImages($array)
    {
        if(!empty($array))
        {
            foreach ($array as $key => $value)
            {
                $value = $this->fileManagerService->handle('images.' . $key , folderName : 'images/info_control');
                $this->infoRepository->updateValues($key,$value);
            }
        }

    }
}
