<?php

namespace App\Http\Controllers\Api\V1\App\ContactUs;

use App\Http\Requests\Api\V1\App\ContactUs\ContactUsRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\App\ContactUs\ContactUsService;

class ContactUsController extends Controller
{
    public function __construct(
        private readonly ContactUsService $contactus,
    )
    {
    }

    public function send(ContactUsRequest $request)
    {
        return $this->contactus->store($request);
    }
}
