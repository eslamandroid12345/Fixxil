<?php

namespace App\Repository;

interface WalletRepositoryInterface extends RepositoryInterface
{
    public function getTotalWallet($id);
}
