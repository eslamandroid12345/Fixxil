<?php

namespace App\Http\Controllers\Api\V1\App\Structure;

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

abstract class StructureController extends Controller
{
    use GeneralTrait;
    use Responser;
    protected string $contentKey;
    protected array $locales;

    protected StructureRepositoryInterface $structureRepository;
    protected FileManagerService $fileManager;
    protected HelperService $helper;

    public function __construct(
        StructureRepositoryInterface $structureRepository,
        FileManagerService $fileManagerService,
        HelperService $helper,
        private readonly GetService              $getService,
    )
    {
//        $this->middleware('auth:api-manager');
//        $this->middleware('permission:structures-update');
        $this->structureRepository = $structureRepository;
        $this->fileManager = $fileManagerService;
        $this->helper = $helper;
    }

    public function index(Request $request)
    {
        $content = json_decode($this->structureRepository->structure($this->contentKey)?->content, true);
        $language = $request->header('Accept-Language');
        return $this->returnData('data',$content[$language]);
    }
}
