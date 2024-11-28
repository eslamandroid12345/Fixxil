<?php

namespace App\Http\Services\Api\V1\Dashboard\ContactUs;

use App\Http\Services\Mutual\FileManagerService;
use App\Repository\ContactUsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Dashboard\ContactUs\ContactUsResource;
use App\Http\Resources\V1\Dashboard\ContactUs\ContactUsCollection;

class ContactUsService
{
    use Responser;

    public function __construct(
        private readonly ContactUsRepositoryInterface $contactusRepository,
        private readonly GetService                   $getService,
        private readonly FileManagerService           $fileManagerService
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(ContactUsCollection::class, $this->contactusRepository,method: 'getAllContactUs',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(ContactUsResource::class, $this->contactusRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function destroy($id)
    {
        try {
            $this->contactusRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
