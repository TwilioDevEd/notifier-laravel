<?php

/**
 * Helper functions related to the manipulation
 * of messages and notifications
 */


/**
 * Parse a command and its parameters from a message
 *
 * @param $msg Text message to parse
 *
 * @return array Parsed content
 */
function parse_message($msg)
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
        $movieTitle = fetch_movie_title($msg);

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
function fetch_movie_title($movieName)
{
    $keyName = str_name_format($movieName);
    $valid_movies = config("app.valid_movies");

    if (array_key_exists($keyName, $valid_movies)) {
        return $valid_movies[$keyName];
    }
}

function str_name_format($movie)
{
    $str = strtolower($movie);
    $str = str_slug($str, "_");
    return $str;
}
