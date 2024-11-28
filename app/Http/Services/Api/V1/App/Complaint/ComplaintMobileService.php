<?php

namespace App\Http\Services\Api\V1\App\Complaint;


class ComplaintMobileService extends ComplaintService
{
    public static function platform(): string
    {
        return 'mobile';
    }
}
