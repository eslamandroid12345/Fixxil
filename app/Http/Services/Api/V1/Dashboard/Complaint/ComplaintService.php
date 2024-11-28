<?php

namespace App\Http\Services\Api\V1\Dashboard\Complaint;

use App\Repository\ComplaintRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Resources\V1\Dashboard\Complaint\ComplaintResource;
use App\Http\Resources\V1\Dashboard\Complaint\ComplaintCollection;
use Illuminate\Http\Request;

class ComplaintService
{
    use Responser;

    public function __construct(
        private readonly ComplaintRepositoryInterface $complaintRepository,
        private readonly GetService              $getService,
    )
    {
    }

    public function index()
    {
        return $this->getService->handle(ComplaintCollection::class, $this->complaintRepository,method: 'getAllComplaints',is_instance: true);
    }

    public function show($id)
    {
        return $this->getService->handle(ComplaintResource::class, $this->complaintRepository, method: 'getById', parameters: [$id], is_instance: true);
    }

    public function destroy($id)
    {
        try
        {
            $this->complaintRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($request,$id)
    {
        try
        {
            $complaint = $this->complaintRepository->getById($id);
            $this->complaintRepository->update($complaint->id,['status'=>$request->status]);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
