<?php

/**
 * Helper functions related to the manipulation
 * of messages and notifications
 */
use App\Notifications\Subscribers\Subscriber;
use Twilio\Rest\Notifications\V1\Service\BindingInstance;


/**
 * Parse a command and its parameters from a message
 *
 * @param $msg Text message to parse
 *
 * @return array Parsed content
 */
function parseMessage($msg)
{
    $result = array();

    $validSmsCommands = config('app.valid_sms_commands');

    $tokens = preg_split('/ +/', $msg, 2);
    $cmdName = strtolower($tokens[0]);

    if (in_array($cmdName, $validSmsCommands)) {
        $result["name"] = $cmdName;

        if (count($tokens) > 1) {
            $result["params"] = $tokens[1];
        }
    } else {
        $movieTitle = fetchMovieTitle($msg);

        if (empty($movieTitle)) {
            $result["name"] = "invalid";
        } else {
            $result["name"] = "subscribe";
            $result["params"] = $movieTitle;
        }
    }

    return $result;
}

/**
 * Retrieves a movie based on an input String
 *
 * @param $movieName movie name in snake case
 *
 * @return mixed Verbose title of the movie
 */
function fetchMovieTitle($movieName)
{
    $keyName = strNameFormat($movieName);
    $valid_movies = config("app.valid_movies");

    if (array_key_exists($keyName, $valid_movies)) {
        return $valid_movies[$keyName];
    }
}

/**
 * Formats a verbose movie title to a tag style name
 *
 * @param $movie verbose movie name. E,g, Rogue One
 *
 * @return string name of the movie with no spaces. E,g, rogue_one
 */
function strNameFormat($movie)
{
    $str = strtolower($movie);
    $str = str_slug($str, "_");
    return $str;
}


function commandName($command)
{
    return $command["name"];
}

function commandParam($command)
{
    if (array_key_exists("params", $command)) {
        return $command["params"];
    }
}

/**
 * Converts an instance of bindings in a abstraction of a subscriber
 *
 * @param BindingInstance $binding
 *
 * @return Subscriber Model of a subcriber
 */
function bindingInstanceToSubscriber(BindingInstance $binding)
{
    $id = $binding->sid;
    $phoneNumber = $binding->address;
    $movies = $binding->tags;

    return new Subscriber($id, $phoneNumber, $movies);
}