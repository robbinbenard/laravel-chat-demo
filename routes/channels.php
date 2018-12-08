<?php

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

Broadcast::channel('rooms', function ($user) {
    return Auth::check();
});

Broadcast::channel('rooms.{room_id}', function ($user, $room_id) {
    if ($user) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
