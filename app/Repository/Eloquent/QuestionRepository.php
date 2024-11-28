<?php

namespace App\Repository\Eloquent;

use App\Models\Question;
use App\Repository\QuestionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class QuestionRepository extends Repository implements QuestionRepositoryInterface
{
    protected Model $model;

    public function __construct(Question $model)
    {
        parent::__construct($model);
    }

}
