<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionRate extends Model
{
    use HasFactory;
    protected $table = 'question_rates';
    protected $guarded = [];
//    protected $fillable = ['rate','question_id','order_id','customer_id','provider_id','comment'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }

    public function customers()
    {
        return $this->belongsTo(User::class,'customer_id');
    }
}
