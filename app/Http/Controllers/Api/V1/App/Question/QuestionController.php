<?php

namespace App\Http\Controllers\Api\V1\App\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\App\Question\QuestionRequest;
use App\Http\Services\Api\V1\App\Question\QuestionService;

class QuestionController extends Controller
{
    public function __construct(
        private readonly QuestionService $question,
    )
    {
        $this->middleware('auth:api-app');
    }

    public function index()
    {
        return $this->question->index();
    }

    public function store(QuestionRequest $request)
    {
        return $this->question->store($request);
    }
}
