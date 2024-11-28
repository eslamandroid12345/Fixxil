<?php

namespace App\Http\Services\Api\V1\App\Complaint;

class ComplaintWebService extends ComplaintService
{
    public static function platform(): string
    {
        return 'website';
    }
}
