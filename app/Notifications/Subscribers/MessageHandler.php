<?php

namespace App\Notifications\Subscribers;


use Twilio\Exceptions\TwilioException;

class MessageHandler implements MoviesNotificationsSubscriptor
{

    /**
     * Handler of basic actions on subscribers
     *
     * @var SubscribersManager
     */
    private $_subscribersManager;

    public function __construct(SubscribersManager $subscribersManager)
    {
        $this->_subscribersManager = $subscribersManager;
    }

    function subscribe($phoneNumber, $movie)
    {
        $subscriber = $this->_subscribersManager->findSubscriber($phoneNumber);

        try {
            if ($subscriber) {
                $subscriber->addMovie($movie);

                $this->_subscribersManager->createOrUpdateSubscriber(
                    $subscriber->getPhoneNumber(),
                    $subscriber->getMovies()
                );
            } else {
                $this->_subscribersManager->createOrUpdateSubscriber(
                    $phoneNumber,
                    $movie
                );
            }

            return "You have been subscribed";
        } catch (TwilioException $e) {
            return $e->getMessage();
        }
    }

    function unsub($phoneNumber, $movie)
    {
        $subscriber = $this->_subscribersManager->findSubscriber($phoneNumber);

        try {
            if ($subscriber) {
                $this->_subscribersManager->deleteSubscriber($subscriber->getId());
            }

            return "You have been unsubscribed";
        } catch (TwilioException $e) {
            return $e->getMessage();
        }
    }

    function help()
    {
        return 'May the Force be with you! ' .
        'To subscribe send the "movie name". ' .
        'To unsubscribe send "unsub movie name" (without the quotes.)';
    }

    function invalid()
    {
        $response = 'Ups! Unknown movie. ' .
            'The supported movies are:';

        $valid_movies = config("app.valid_movies");
        foreach ($valid_movies as $movie) {
            $response .= PHP_EOL . $movie;
        }

        return $response;
    }
}