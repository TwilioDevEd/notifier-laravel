<?php

namespace App\Providers;

use App\Notifications\MoviesNotifier;
use App\Notifications\NotificationsHandler;
use App\Notifications\NotificationsManager;
use App\Notifications\Subscribers\MessageHandler;
use App\Notifications\Subscribers\MoviesNotificationsSubscriptor;
use App\Notifications\Subscribers\SubscribersHandler;
use App\Notifications\Subscribers\SubscribersManager;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;
use Twilio\Rest\Notifications\V1\ServiceContext as NotificationService;

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
            or die("{Client::ENV_ACCOUNT_SID} is not set in the environment");
            $authToken = config('services.twilio')['authToken']
            or die("{Client::ENV_AUTH_TOKEN} is not set in the environment");

            return new Client($accountSid, $authToken);
        });

        $this->app->singleton(NotificationService::class, function ($app) {
            $twilioClient = $app[Client::class];
            $twilioApiConfig = config("services.twilio");
            $notificationServSid = $twilioApiConfig["notificationServiceSid"]
            or die(
            "TWILIO_NOTIFICATION_SERVICE_SID is not set in the environment"
            );

            return $twilioClient->notifications->services()
                ->getContext($notificationServSid);
        });

        $this->app->singleton(MoviesNotificationsSubscriptor::class, function ($app) {
            $subscriberManager = $app[SubscribersManager::class];

            return new MessageHandler($subscriberManager);
        });

        $this->app->singleton(SubscribersManager::class, function ($app) {
            $notificationService = $app[NotificationService::class];

            return new SubscribersHandler($notificationService);
        });

        $this->app->singleton(NotificationsManager::class, function ($app) {
            $notificationService = $app[NotificationService::class];

            return new NotificationsHandler($notificationService);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class, MoviesNotificationsSubscriptor::class];
    }
}