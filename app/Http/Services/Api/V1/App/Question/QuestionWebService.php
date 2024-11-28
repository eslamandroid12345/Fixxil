<?php

namespace App\Http\Services\Api\V1\App\Question;

use App\Http\Services\Api\V1\App\Question\QuestionService;

class QuestionWebService extends QuestionService
{
    public static function platform(): string
    {
        return 'website';
    }
}
