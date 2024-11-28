<?php

namespace App\Repository\Eloquent;
use Carbon\Carbon;
use App\Models\WalletTransaction;
use App\Repository\WalletTransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class WalletTransactionRepository extends Repository implements WalletTransactionRepositoryInterface
{
    protected Model $model;

    public function __construct(WalletTransaction $model)
    {
        parent::__construct($model);
    }

    public function getAllDeposit($id)
    {
         $details =  $this->model::query()->where('user_id',$id)->where('status','deposit')->get();
         foreach($details as $detail)
        {
            $carbon_updated_at = Carbon::parse($detail->created_at);
            $days_difference = $carbon_updated_at->diffInDays(Carbon::now());
            $formatted_updated_at = $carbon_updated_at->subDays($days_difference)->diffForHumans();
            $detail->date = $formatted_updated_at;
        }
         return $details;
    }
    public function getLastTransactions(){
        return $this->model::query()
            ->with('wallet')
            ->latest()
            ->take(5)->get();
    }
    public function getAllPayments()
    {
        return $this->model::query()
            ->when(request()->has('search') && request('search') != null, function ($query) {
                $search = '%' . request('search') . '%';
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
                });
            })
            ->when(request()->has('date_from') && request('date_from') != null, function ($q) {
                $q->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request()->has('date_to') && request('date_to') != null, function ($q) {
                $q->whereDate('created_at', '<=', request('date_to'));
            })
            ->latest()->paginate(request('perPage'));
    }

}
