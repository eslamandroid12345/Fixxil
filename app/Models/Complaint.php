<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';
    protected $guarded = [];


    public function statusValue() : Attribute
    {
        return Attribute::get(function ()
        {
            if($this->status == 'in_progress')
                return __('general.offer_in_progress');
            elseif($this->status == 'doing')
                return __('general.doing');
            else
                return __('general.done');
        });
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
