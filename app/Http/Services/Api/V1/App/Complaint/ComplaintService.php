<?php

namespace App\Http\Services\Api\V1\App\Complaint;

use App\Http\Requests\Api\V1\App\Complaint\ComplaintRequest;
use App\Http\Services\Mutual\GetService;
use App\Http\Services\PlatformService;
use App\Http\Traits\Notification;
use App\Http\Traits\Responser;
use App\Notifications\ComplainNotification;
use App\Repository\ComplaintRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\OrderRepositoryInterface;
use Exception;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\App\Complaint\ComplaintResource;
use App\Http\Resources\V1\App\Complaint\ComplaintOrderResource;

abstract class ComplaintService extends PlatformService
{
    use Responser,Notification;

    public function __construct(
        private readonly ComplaintRepositoryInterface $complaintRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly FileManagerService           $fileManagerService,
        private readonly ManagerRepositoryInterface      $managerRepository,
        private readonly GetService                   $getService,
    )
    {
    }

    public function store($request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated();
            $user = $this->userRepository->getById(auth('api-app')->id());
            $order = $this->orderRepository->getById($request->order_id);
            $data = array_merge($data, ["from" => $user->id]);
            if($user->type == "customer")
            {
                $data = array_merge($data, ["to" => $order->provider->id]);
            }
            else
            {
                $data = array_merge($data, ["to" => $order->customer->id]);
            }
            $managers = $this->managerRepository->getAll();
            $complain = $this->complaintRepository->create($data);
            $this->SendNotification(ComplainNotification::class, $managers, [
                'complain_id' => $complain->id,
            ]);
            DB::commit();
            return $this->responseSuccess(message: __('messages.created successfully'));
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getAllOrdersComplaint()
    {
        $id = auth('api-app')->id();
        return $this->getService->handle(ComplaintOrderResource::class, $this->orderRepository, 'getAllOrdersComplaint', parameters: [$id]);
    }

}
