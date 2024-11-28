<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('App.Models.Manager.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('users.{user_id}', function ($user, $user_id) {
    return (int)$user->id === (int)$user_id;
});

Broadcast::channel('chat.room.{room_id}', function ($user, $room_id) {
    return $user->chatRooms?->contains('chat_room_id', $room_id);
});

Broadcast::channel('private.chatroom.status.change.{room_id}', function ($user, $room_id) {
    return $user->chatRooms?->contains('chat_room_id', $room_id);
});

Broadcast::channel('private.buttons.changed.{room_id}', function ($user, $room_id) {
    return $user->chatRooms?->contains('chat_room_id', $room_id);
});

Broadcast::channel('chat.rooms.{user_id}', function ($user, $user_id) {
    return $user->chatRooms()?->exists();
});
