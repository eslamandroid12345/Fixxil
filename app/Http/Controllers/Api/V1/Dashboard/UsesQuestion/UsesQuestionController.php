<?php

namespace App\Http\Controllers\Api\V1\Dashboard\UsesQuestion;
use App\Http\Requests\Api\V1\Dashboard\UsesQuestion\UsesQuestionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Api\V1\Dashboard\UsesQuestion\UsesQuestionService;

class UsesQuestionController extends Controller
{
    public function __construct(private readonly UsesQuestionService $uses)
    {
        $this->middleware('auth:api-manager');

        $this->middleware('permission:uses-question-read')->only('index');
        $this->middleware('permission:uses-question-show')->only('show');
        $this->middleware('permission:uses-question-create')->only('store');
        $this->middleware('permission:uses-question-update')->only('update');
        $this->middleware('permission:uses-question-delete')->only('destroy');
    }

    public function index($use_id)
    {
        return $this->uses->index($use_id);
    }

    public function show($use_id,$id)
    {
        return $this->uses->show($use_id,$id);
    }

    public function store(UsesQuestionRequest $request,$use_id)
    {
        return $this->uses->store($request,$use_id);
    }

    public function update(UsesQuestionRequest $request, $use_id,$id)
    {
        return $this->uses->update($request,$use_id, $id);
    }

    public function destroy($use_id,$id)
    {
        return $this->uses->destroy($use_id,$id);
    }
}
