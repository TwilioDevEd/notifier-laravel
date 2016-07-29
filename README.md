<a href="https://www.twilio.com">
  <img src="https://static0.twilio.com/marketing/bundles/marketing/img/logos/wordmark-red.svg" alt="Twilio" width="250" />
</a>

# Notifier and SMS Notifications with Twilio Notify

[![Build Status](https://travis-ci.org/TwilioDevEd/notifier-laravel.svg?branch=master)](https://travis-ci.org/TwilioDevEd/notifier-laravel)

Tag users and send group notifications with one request. Twilio alerts everyone
that matches the specified tags.

## Local Development

This project is build using [Laravel](https://laravel.com).

1. First clone this repository and `cd` into it.

   ```bash
   $ git clone git@github.com:TwilioDevEd/notifier-laravel.git
   $ cd notifier-laravel
   ```

1. Install the dependencies with [Composer](https://getcomposer.org/).

   ```bash
   $ composer install
   ```
   
1. Setup the project environment executing:

   ```bash
   $ php artisan setup
   ```     
   
   This also
   * Creates your `.env` file for you to add your private credentials.
   * Generates an `APP_KEY`.
   
   You can find your `TWILIO_ACCOUNT_SID` and `TWILIO_AUTH_TOKEN` in your
   [Twilio Account Settings](https://www.twilio.com/user/account/settings).
   You will also need a `TWILIO_NUMBER`, which you may find [here](https://www.twilio.com/user/account/phone-numbers/incoming).

   You can find your `TWILIO_NOTIFICATION_SERVICE_SID` in you console under
   [services](https://www.twilio.com/console/notify/services).
   
1. Make sure the tests succeed.

   ```bash
   $ ./vendor/bin/phpunit
   ```

1. Start the server.

   ```bash
   $ php artisan serve
   ```

1. Check it out at [http://localhost:8000](http://localhost:8000).

## How to Demo

#### For Help Instructions

1. Text your Twilio number "help me". e.g.

   ```
   Help me
   ```

1. Receive a message with instructions.

#### To Create a Subscription

1. Text your Twilio number the name of the movie you to be subscribed. e.g.

   ```
   Rogue One
   ```

   **Note**: The available movies are "Han Solo Spinoff", "Rogue One", and "Episode VIII".

1. Receive a confirmation message.

#### To Delete a Subscription

1. Text your Twilio number with "usub movie name". e.g.

   ```
   unsub Rogue One
   ```

1. Receive a confirmation message.

## Meta

* No warranty expressed or implied. Software is as is. Diggity.
* [MIT License](http://www.opensource.org/licenses/mit-license.html)
* Lovingly crafted by Twilio Developer Education.