<?php

namespace App\Repository;

interface InfoRepositoryInterface extends RepositoryInterface
{
    public function getText();
    public function updateValues($key,$value);
    public function pointDiscount();
    public function pointPrice();
}
