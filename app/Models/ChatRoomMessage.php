<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_room_messages';
    protected $guarded = [];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = base64_encode($value);
    }

    public function getContentAttribute($value)
    {
        return base64_decode($value);
    }

    public function typeValue(): Attribute
    {
        return Attribute::get(function () {
            return __('db.chat_types.' . $this->type);
        });
    }

    public function contentValue(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type === 'IMAGE' || $this->type === 'AUDIO' || $this->type === 'FILE' && $this->content != null)
                return url($this->content);
            return $this->content;
        });
    }

    public function contentValueDashboard(): Attribute
    {
        return Attribute::get(function () {
            if ($this->type === 'IMAGE' || $this->type === 'AUDIO' || $this->type === 'FILE' && $this->content != null)
                return url($this->content);
            return $this->content;
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }
}
