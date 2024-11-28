<?php

namespace App\Repository;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getAllCategoryHome();
    public function getAllCategory();
    public function getAllCategoryDashboard();
    public function getCategoriesForHome();
    public function getAllMainCateogries();
}
