<?php

use App\Notifications\TestNotification;
use Pusher\Pusher;

if (!function_exists('customFunction')) {
    function customFunction($value) {
        // Thực hiện logic của bạn ở đây
        return strtoupper($value);
    }
}

if (!function_exists('sendNotification')) {
     function sendNotification($user, $userCreate,$notification = 'Create new account')
    {
        $data = [
            'user_id'=> $user->id,
            'own_id' => $userCreate->id,
            'name' => $user->name,
            'notification' => $notification,
            'role' => $userCreate->roles[0]->id == 2 ? 2 : 1
            // 1 laf admin, 2 resident
        ];

        $user->notify(new TestNotification($data));
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger('NotificationEvent', 'send-message', $data);
    }
}
