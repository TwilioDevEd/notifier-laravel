<?php

namespace App\Notifications\Subscribers;


interface MoviesSubscriptor
{

    function help();

    function subscribe($phoneNumber, $movie);

    function unsub($phoneNumber, $movie);

    function invalid();
}