<?php

namespace App\Http\Services\Api\V1\App\ContactUs;

class ContactUsWebService extends ContactUsService
{
    public static function platform(): string
    {
        return 'website';
    }
}
