<?php

namespace App\Providers;

use App\Messages\MessagesFacade;
use App\Messages\MessagesParser;
use App\Notifications\MoviesNotifier;
use App\Notifications\NotificationsFacade;
use app\Notifications\NotificationsManager;
use App\Notifications\Subscribers\MoviesSubscriptor;
use App\Notifications\Subscribers\SubscribersFacade;
use App\Notifications\Subscribers\SubscribersManager;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class TwilioProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            $accountSid = config('services.twilio')['accountSid']
            or die("TWILIO_ACCOUNT_SID is not set in the environment");
            $authToken = config('services.twilio')['authToken']
            or die("TWILIO_AUTH_TOKEN is not set in the environment");

            return new Client($accountSid, $authToken);
        });

        $subscriberFacade = new SubscribersFacade();

        $this->app->instance(
            MoviesSubscriptor::class,
            $subscriberFacade
        );
        $this->app->instance(
            SubscribersManager::class,
            $subscriberFacade
        );

        $notifierFacade = new NotificationsFacade();

        $this->app->instance(
            MoviesNotifier::class,
            $notifierFacade
        );
        $this->app->instance(
            NotificationsManager::class,
            $notifierFacade
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class, MoviesSubscriptor::class];
    }
}