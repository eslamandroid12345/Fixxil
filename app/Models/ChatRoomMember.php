<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMember extends Model
{
    use HasFactory;
    protected $table = 'chat_room_members';
    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
