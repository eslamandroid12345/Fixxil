<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Complaint;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Complaint\ComplaintService;
use App\Models\Review;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function __construct(
        private readonly ComplaintService $complaint,
    )
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:complaint-read')->only('index');
        $this->middleware('permission:complaint-show')->only('show');
        $this->middleware('permission:complaint-update')->only('changeStatus');
        $this->middleware('permission:complaint-delete')->only('destroy');
    }

    public function index()
    {
        return $this->complaint->index();
    }

    public function show($id)
    {
        return $this->complaint->show($id);
    }

    public function destroy($id)
    {
        return $this->complaint->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->complaint->changeStatus($request,$id);
    }
}
