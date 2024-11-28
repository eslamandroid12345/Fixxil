<?php

namespace App\Http\Controllers\Api\V1\Dashboard\ContactUs;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\ContactUs\ContactUsService;

class ContactUsController extends Controller
{
    public function __construct(private readonly ContactUsService $contactUs)
    {
        $this->middleware('auth:api-manager');
        $this->middleware('permission:contactus-read')->only('index');
        $this->middleware('permission:contactus-show')->only('show');
        $this->middleware('permission:contactus-delete')->only('destroy');
    }

    public function index()
    {
        return $this->contactUs->index();
    }

    public function show($id)
    {
        return $this->contactUs->show($id);
    }

    public function destroy($id)
    {
        return $this->contactUs->destroy($id);
    }
}
