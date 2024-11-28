<?php

namespace App\Repository;

interface SubCategoryRepositoryInterface extends RepositoryInterface
{
    public function getByCategoryId($id);
}
