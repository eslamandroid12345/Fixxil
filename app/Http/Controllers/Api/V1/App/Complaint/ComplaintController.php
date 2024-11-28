<?php

namespace App\Http\Controllers\Api\V1\App\Complaint;

use App\Http\Requests\Api\V1\App\Complaint\ComplaintRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\Complaint\ComplaintService;

class ComplaintController extends Controller
{
    public function __construct(
        private readonly ComplaintService $complaint,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function store(ComplaintRequest $request)
    {
        return $this->complaint->store($request);
    }

    public function getAllOrdersComplaint()
    {
        return $this->complaint->getAllOrdersComplaint();
    }
}
