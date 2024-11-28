<?php

namespace App\Repository\Eloquent;

use App\Models\QuestionRate;
use App\Repository\QuestionRateRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class QuestionRateRepository extends Repository implements QuestionRateRepositoryInterface
{
    protected Model $model;

    public function __construct(QuestionRate $model)
    {
        parent::__construct($model);
    }

}
