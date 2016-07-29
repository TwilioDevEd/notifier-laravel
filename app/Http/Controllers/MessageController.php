<?php

namespace App\Http\Controllers;

use App\Notifications\Subscribers\MoviesNotificationsSubscriptor;
use Illuminate\Http\Request;
use Twilio\Twiml;

class MessageController extends Controller
{
    private $_subscriber;

    public function __construct(MoviesNotificationsSubscriptor $subscriber)
    {
        $this->_subscriber = $subscriber;
    }

    public function postIncoming(Request $request)
    {
        $message = $request->input("Body");
        $phoneNumber = $request->input("From");

        $response = $this->_getReponseFromMessage($message, $phoneNumber);

        $twimlResponse = new Twiml();
        $twimlResponse->message($response);

        return response($twimlResponse)->header('Content-Type', 'text/xml');
    }

    private function _getReponseFromMessage($message, $phoneNumber)
    {
        $command = parseMessage($message);
        $commandName = $command["name"];

        switch ($commandName) {
        case "help":
            return $this->_subscriber->help();
        case "unsub":
        case "subscribe":
            $movieName = commandParam($command);
            $valid_movies = config("app.valid_movies");

            if (in_array($movieName, $valid_movies)) {
                if (!empty($movieName)) {
                    return $this->_subscriber
                        ->$commandName($phoneNumber, $movieName);
                }
            }
        case "invalid":
        default:
            return $this->_subscriber->invalid();
        }
    }
}
