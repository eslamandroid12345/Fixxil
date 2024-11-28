<?php

namespace App\Http\Services\Api\V1\App\ContactUs;

class ContactUsMobileService extends ContactUsService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
