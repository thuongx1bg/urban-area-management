<?php

use App\Notifications\TestNotification;
use Illuminate\Support\Facades\File;
use Pusher\Pusher;
use Spatie\Crypto\Rsa\KeyPair;

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

if (!function_exists('createKey')) {
     function createKey($username)
    {
        $pathToPrivateKey = ("keys/" . $username);
        $pathToPublicKey = ("keys/" . $username);

        if (!File::exists(storage_path($pathToPrivateKey))) {
            File::makeDirectory(storage_path($pathToPrivateKey), 0775, true);
        }
        if (!File::exists(storage_path($pathToPublicKey))) {
            File::makeDirectory(storage_path($pathToPublicKey), 0775, true);
        }

        [$privateKey, $publicKey] = (new KeyPair())->generate(storage_path($pathToPrivateKey . "/private.txt"), storage_path($pathToPublicKey . "/public.txt"));

        return [$privateKey, $publicKey];
    }
}
