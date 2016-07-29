<?php

namespace App\Notifications\Subscribers;


interface MoviesNotificationsSubscriptor
{

    function help();

    function subscribe($phoneNumber, $movie);

    function unsub($phoneNumber, $movie);

    function invalid();
}