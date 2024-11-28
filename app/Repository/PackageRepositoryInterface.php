<?php

namespace App\Repository;

interface PackageRepositoryInterface extends RepositoryInterface
{
    public function getAllPackages();
    public function getAllPackagesDashboard();
}
