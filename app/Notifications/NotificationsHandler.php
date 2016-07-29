<?php

namespace App\Notifications;

use Twilio\Rest\Notifications\V1\ServiceContext as NotificationService;

class NotificationsHandler implements NotificationsManager
{
    /**
     * Handler for the Twilio Notification Service
     *
     * @var NotificationService
     */
    private $_notificationsService;

    /**
     * NotificationsFacade constructor.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->_notificationsService = $notificationService;
    }

    public function createNotification($movie, $message)
    {
        $twilioPhoneNumber = config("services.twilio")["number"] or die(
            "TWILIO_NUMBER is not set in the environment"
        );

        return $this->_notificationsService->notifications->create(
            [
                'tag' => $movie,
                'body' => $message,
                'sms' => json_encode(
                    [
                    "from" => $twilioPhoneNumber
                    ]
                )
            ]
        );
    }
}