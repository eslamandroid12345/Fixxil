<?php

namespace App\Repository;

interface UsesRepositoryInterface extends RepositoryInterface
{
    public function getAllUsesForCategory($use_id);
    public function getAllQuestionForuses($use_id);

}
