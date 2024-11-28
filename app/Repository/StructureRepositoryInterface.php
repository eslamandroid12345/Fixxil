<?php

namespace App\Repository;

interface StructureRepositoryInterface extends RepositoryInterface
{
    public function structure($key);

    public function publish($key , $content);
}
