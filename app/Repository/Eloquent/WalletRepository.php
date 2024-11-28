<?php

namespace App\Repository\Eloquent;

use App\Models\Wallet;
use App\Repository\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class WalletRepository extends Repository implements WalletRepositoryInterface
{
    protected Model $model;

    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }

    public function getTotalWallet($id)
    {
        return $this->model::query()->where('user_id',$id)->first();
    }

}
