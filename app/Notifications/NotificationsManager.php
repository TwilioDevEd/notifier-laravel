<?php
namespace App\Notifications;


interface NotificationsManager
{

    public function createNotification($movie, $message);
}