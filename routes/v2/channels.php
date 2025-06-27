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

// Driver notification channel
Broadcast::channel('driver.{driverId}', function ($user, $driverId) {
    // Check if the authenticated user is the driver or has permission to access this channel
    if ($user->user_type === 'driver') {
        // For drivers, check if they own this channel
        $driver = \App\Models\V2\Driver::where('user_id', $user->id)->first();
        return $driver && (int) $driver->id === (int) $driverId;
    }
    
    // For admin/operators, allow access to all driver channels in their organization
    return $user->user_type === 'admin' || $user->user_type === 'operator';
});
