<?php

namespace App\Helpers;

use App\Models\Notification;

class Notify
{
    public static function send($userId, $title, $message, $type = 'order')
    {
        return Notification::create([
            'user_id'  => $userId,
            'title'    => $title,
            'message'  => $message,
            'type'     => $type,
            'is_read'  => false,
        ]);
    }
}
