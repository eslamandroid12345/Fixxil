<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Question;
use App\Http\Requests\Api\V1\Dashboard\Question\QuestionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\Question\QuestionService;

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionService $question)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:question-read')->only('index');
        $this->middleware('permission:question-show')->only('show');
        $this->middleware('permission:question-create')->only('store');
        $this->middleware('permission:question-update')->only('update','changeStatus');
        $this->middleware('permission:question-delete')->only('destroy');
    }

    public function index()
    {
        return $this->question->index();
    }

    public function show($id)
    {
        return $this->question->show($id);
    }

    public function store(QuestionRequest $request)
    {
        return $this->question->store($request);
    }

    public function update(QuestionRequest $request, $id)
    {
        return $this->question->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->question->destroy($id);
    }

    public function changeStatus(Request $request,$id)
    {
        return $this->question->changeStatus($request,$id);
    }
}
