<?php

namespace App\Http\Controllers;

use App\Notifications\Subscribers\MoviesSubscriptor;
use Illuminate\Http\Request;
use Twilio\Twiml;

class SubscriberController extends Controller
{
    private $_subscriber;

    public function __construct(MoviesSubscriptor $subscriber)
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
        $command = parse_message($message);
        $commandName = $command["name"];

        switch ($commandName) {
            case "help":
                return $this->_subscriber->help();
            case "unsub":
            case "subscribe":
                $commandParams = $command["params"];
                return $this->_subscriber->$commandName($phoneNumber, $commandParams);
            case "invalid":
            default:
                return $this->_subscriber->invalid();
        }
    }
}
