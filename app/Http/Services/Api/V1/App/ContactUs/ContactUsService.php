<?php

namespace App\Http\Services\Api\V1\App\ContactUs;

use App\Http\Requests\Api\V1\App\ContactUs\ContactUsRequest;
use App\Http\Services\PlatformService;
use App\Http\Traits\Responser;
use App\Repository\ContactUsRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class ContactUsService extends PlatformService
{
    use Responser;

    public function __construct(
        private readonly ContactUsRepositoryInterface $contactusRepository,
    )
    {
    }

    public function store(ContactUsRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = auth('api-app')->id();
            $this->contactusRepository->create($data);
            DB::commit();
            return $this->responseSuccess(message: __('messages.sent successfully'));
        } catch (Exception $e) {
            DB::rollBack();
//            dd($e);
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
