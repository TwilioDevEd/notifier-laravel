<?php

use Twilio\Rest\Client;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Twilio, Stripe, Mailgun, Mandrill, and others. This file provides a
    | sane default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */


    'twilio' => [

        /**
         * Twilio Api variables to use
         */
        'accountSid' => env(Client::ENV_ACCOUNT_SID),
        'authToken' => env(Client::ENV_AUTH_TOKEN),
        'number' => env('TWILIO_NUMBER')
    ]

];
