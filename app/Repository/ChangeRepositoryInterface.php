<?php

namespace App\Repository;

interface ChangeRepositoryInterface extends RepositoryInterface
{
    public function paginateChangesDashboard();
}
