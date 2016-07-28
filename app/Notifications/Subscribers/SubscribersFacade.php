<?php

namespace App\Notifications\Subscribers;


class SubscribersFacade implements MoviesSubscriptor, SubscribersManager
{

    function subscribe($phoneNumber, $movie)
    {

    }

    function unsub($phoneNumber, $movie)
    {

    }

    function help()
    {
        return 'May the Force be with you!' .
        'To subscribe send the "movie name".' .
        'To unsubscribe send "unsub movie name" (without the quotes.)';
    }

    function invalid()
    {
        $response = 'Ups! Unknown movie.' .
            'The supported movies are:';

        $valid_movies = config("app.valid_movies");
        foreach ($valid_movies as $movie) {
            $response .=  PHP_EOL . $movie;
        }

        return $response;
    }
}