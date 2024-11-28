<?php

namespace App\Http\Controllers\Api\V1\App\Negotiates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Negotiates\NegotiateRequest;
use App\Http\Services\Api\V1\App\Negotiates\NegotiatesService;
use Illuminate\Http\Request;

class NegotiatesController extends Controller
{

    public function __construct(
        private readonly NegotiatesService $negotiatesService
    ){

    }
    public function negotiate(NegotiateRequest $request){
        return $this->negotiatesService->negotiate($request);
    }
}
