<?php
namespace app\Notifications;


interface NotificationsManager
{

    public function createNotification($movie, $message);
}