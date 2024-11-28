<?php

namespace App\Repository;

interface UserTimeRepositoryInterface extends RepositoryInterface
{
    public function getTimeForUser($id,$day);
    public function getFromToForDay($provider_id,$day);
}
