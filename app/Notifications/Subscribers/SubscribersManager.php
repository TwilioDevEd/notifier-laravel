<?php

namespace App\Notifications\Subscribers;
use Twilio\Rest\Notifications\V1\Service\BindingContext;

/**
 * Interface SubscribersManager defines a manipulator of Subscriber
 * for search actions or CRUD
 *
 * @package App\Notifications\Subscribers
 */
interface SubscribersManager
{
    function findSubscriber($subscriberPhoneNumber);

    function createOrUpdateSubscriber($subscriberPhoneNumber, $movies);

    function deleteSubscriber($id);
}