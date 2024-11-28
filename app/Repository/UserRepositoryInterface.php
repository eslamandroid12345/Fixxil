<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getActiveUsers();
    public function getAllUsers();
    public function getProfile();
    public function getAllUsersBySubCategory($id);
    public function getUserBySubCategory($subcategory_id,$id);
    public function withdrawPointsFromWallet($provider_id);

    public function getUserBySearch($request);
    public function getLastUsers();
    public function checkItem($byColumn, $value);
}
