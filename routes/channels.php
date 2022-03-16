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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('prescription.1', function ($user, $prescriptionId) {
    return $user->role->medecin_presc === "on";
});

Broadcast::channel('channel', function () {
    return true;
});

Broadcast::channel('chat',function($user){
	return ['name'=>$user->name];
});