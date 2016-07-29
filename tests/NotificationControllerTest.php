<?php

use App\Notifications\NotificationsHandler;
use App\Notifications\NotificationsManager;
use Mockery\MockInterface;

class NotificationControllerTest extends TestCase
{

    /**
     * Handler for the Twilio Notification Service
     *
     * @var MockInterface
     */
    private $_notificationHandler;

    function setUp()
    {
        parent::setUp();

        /**
         * IoC Dependencies for  NotificationController
         */

        $this->_notificationHandler = Mockery::mock(NotificationsHandler::class)
            ->makePartial();

        $this->instance(NotificationsManager::class, $this->_notificationHandler);
    }

    public function testIndex()
    {
        //When
        $this->visit('/');

        //Then
        $this->see("Episode VIII")
            ->see("Rogue One")
            ->see("Han Solo Spinoff");
    }

    public function testStore()
    {
        $this->_notificationHandler->shouldReceive("createNotification")
            ->once()
            ->andReturn(true);

        //When
        $this->post(
            "/",
            [
                "message" => "Test message",
                "movie" => "han_solo_spinoff",
            ]
        );

        //Then
        $this->assertRedirectedToRoute("notification..index");
    }
}
