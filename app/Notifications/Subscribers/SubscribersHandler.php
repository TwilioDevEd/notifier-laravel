<?php

namespace App\Notifications\Subscribers;

use Twilio\Rest\Notifications\V1\ServiceContext as NotificationService;

class SubscribersHandler implements SubscribersManager
{
    private $_notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->_notificationService = $notificationService;
    }


    public function findSubscriber($subscriberPhoneNumber)
    {
        $bindings = $this->_notificationService->bindings->read(
            array(
                "address" => $subscriberPhoneNumber
            )
        );
        if ($bindings) {
            return bindingInstanceToSubscriber($bindings[1]);
        }
    }

    public function createOrUpdateSubscriber($subscriberPhoneNumber, $movies)
    {
        $bindingInstance = $this->_notificationService->bindings->create(
            $subscriberPhoneNumber . ":sms",
            $subscriberPhoneNumber,
            "sms",
            $subscriberPhoneNumber,
            [
                'tag' => $movies
            ]
        );

        return bindingInstanceToSubscriber($bindingInstance);
    }

    public function deleteSubscriber($id)
    {
        return $this->_notificationService->bindings($id)
            ->delete();
    }
}