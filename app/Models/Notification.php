<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;

class Notification extends DatabaseNotification
{
    protected $table = 'notifications';
    public $usesUniqueIds=false;
    protected $guarded = [];
//    protected $primaryKey = 'id';
//    public $incrementing = true;
    protected $keyType = 'int';
    public function content(): Attribute
    {
        return Attribute::make(get: function () {
            $locale = app()->getLocale();
            return json_decode($this->data, true)[$locale];
        });
    }

    public function isRead(): Attribute
    {
        return Attribute::make(get: fn() => $this->read_at != null);
    }

}
