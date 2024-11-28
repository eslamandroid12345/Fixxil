<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table = 'wallet_transactions';
    protected $guarded = [];
    
    public function statusValue():Attribute {
        return Attribute::make(get: function (){
            if($this->status=='deposit')
                return __('dashboard.deposit');
            else if($this->status=='withdraw')
                return __('dashboard.withdraw');
        });
    }
    public function wallet()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
