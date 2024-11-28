<?php

namespace App\Repository;

interface WalletTransactionRepositoryInterface extends RepositoryInterface
{
    public function getAllDeposit($id);
    public function getLastTransactions();

    public function getAllPayments();
}
