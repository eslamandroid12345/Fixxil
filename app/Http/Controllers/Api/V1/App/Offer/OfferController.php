<?php

namespace App\Http\Controllers\Api\V1\App\Offer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Offer\OfferRequest;
use Exception;
use App\Http\Services\Api\V1\App\Offer\OfferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function __construct(private readonly OfferService $offer)
    {
        $this->middleware('auth:api-app');
    }

    public function store(OfferRequest $request)
    {
        return $this->offer->store($request);
    }

    public function getAllOffers()
    {
        return $this->offer->getAllOffers();
    }
}
