<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    use HasFactory;

    protected $table = 'chat_rooms';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function members()
    {
        return $this->hasMany(ChatRoomMember::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatRoomMessage::class,'chat_room_id');
    }



    public function latestMessageContent(): Attribute
    {
        return Attribute::get(function () {
            $content = $this->latestMessage?->content;
            $type = $this->latestMessage?->type;
            $latestMessageContent = '';

            if ($type == 'TEXT') {
                $latestMessageContent .= $content;
            } else {
                $latestMessageContent .= $this->latestMessage?->type_value;
            }
            return Str::limit($latestMessageContent, 30);
        });
    }

    public function unreadCount(): Attribute
    {
        return Attribute::get(function () {
            return $this->currentMember?->unread_count;
        });
    }

    public function hasMessage(): Attribute
    {
        return Attribute::get(function () {
            return $this->messages()?->count() > 0;
        });
    }


    public function latestMessage()
    {
        return $this->hasOne(ChatRoomMessage::class)->orderByDesc('id')->limit(1);
    }

    public function otherParty()
    {
        return $this->hasOne(ChatRoomMember::class)->where('user_id', '!=', auth('api-app')->id())->limit(1);
    }

    public function currentMember()
    {
        return $this->hasOne(ChatRoomMember::class)->where('user_id', auth('api-app')->id())->limit(1);
    }
}
