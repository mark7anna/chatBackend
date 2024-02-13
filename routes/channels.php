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


// Route::get('roomenter', function() {
//     event(new App\Events\TestEvent());
// });
// ::channel('roomenter', function () {
//     event(new App\Events\TestEvent());
//     return null ;
// });

Broadcast::channel('public.room.enter', function() {
   return true ;
});