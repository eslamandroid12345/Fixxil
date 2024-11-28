<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Structure;

use App\Http\Controllers\Controller;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\Mutual\HelperService;
use App\Http\Traits\Responser;
use App\Repository\StructureRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\V1\Dashboard\Structure\StructureResource;

abstract class ApiStructureController extends Controller
{
    use GeneralTrait;
    use Responser;

    protected string $contentKey;


    public function __construct(
        private readonly StructureRepositoryInterface $structureRepository,
        private readonly FileManagerService           $fileManager,
        private readonly HelperService                $helper,
        private readonly GetService                   $getService,
    )
    {
        $this->middleware('auth:api-manager');
    }

    public function index(Request $request)
    {
        $content = json_decode($this->structureRepository->structure($this->contentKey)?->content, true);
        return $this->returnData('data', $content);
    }

    public function _store(Request $request)
    {
        $content = json_encode($this->build($request));
        $this->structureRepository->publish($this->contentKey, $content);
        return $this->responseSuccess(message: __('messages.created successfully'));
    }

    private function build($request)
    {
        $data = $request->validated();
        $files = isset($data['files']) ? $this->uploadFiles($data['files']) : [];
        if(isset($data['old_files']))
            $this->deleteOldFiles($data['old_files']);
        $content = $data['content'] ?? [];
        return $this->processData($content, $files);
    }

    private function processData($data, $uploadedFiles)
    {
        $processedData = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $processedData[$key] = $this->processData($value, $uploadedFiles);
            } elseif (array_key_exists($value, $uploadedFiles)) {
                $processedData[$key] = $uploadedFiles[$value];
            } else {
                $processedData[$key] = $value;
            }
        }
        return $processedData;
    }

    private function uploadFiles($files)
    {
        $uploadedFiles = [];
        if ($files !== null) {
            foreach ($files as $key => $file) {
                $uploadedFiles[$key] = url($this->fileManager->uploadFile($file, 'content'));
            }
        }
        return $uploadedFiles;
    }

    private function deleteOldFiles($urls)
    {
        foreach ($urls as $url) {
            $this->fileManager->deleteFile($this->getPathFromUrl($url));
        }
    }

    private function getPathFromUrl($url)
    {
        $pattern = '/storage(.*)$/';
        if (preg_match($pattern, $url, $matches)) {
            $pathFromStorage = $matches[1];
            $fullPath = "storage/" . $pathFromStorage;
            return $fullPath;
        }
        return 0;
    }

}
