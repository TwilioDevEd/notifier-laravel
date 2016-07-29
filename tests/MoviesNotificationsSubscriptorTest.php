<?php

use App\Notifications\Subscribers\Subscriber;
use App\Notifications\Subscribers\SubscribersHandler;
use App\Notifications\Subscribers\SubscribersManager;

class MoviesNotificationsSubscriptorTest extends TestCase
{
    /**
     * Test `help` command
     *
     * @return void
     */
    public function testHelpMessage()
    {
        //When
        $this->post(
            '/message/incoming',
            [
                "Body" => "Help me",
                "From" => "+1234567890",
            ]
        );

        //Then
        $this->see("May the Force be with you!")
            ->see("To subscribe send the \"movie name\"")
            ->see("To unsubscribe send \"unsub movie name\" (without the quotes.)");
    }

    /**
     * Test subscriptions
     *
     * @return void
     */
    public function testSubscriptionMessage()
    {
        //Given
        $subscriberHandler = Mockery::mock(SubscribersHandler::class)
            ->makePartial();

        $subscriberMock = new Subscriber("id", "+1234567890", ["Rogue One"]);

        $subscriberHandler->shouldReceive("findSubscriber")
            ->once()
            ->andReturn($subscriberMock);

        $subscriberHandler->shouldReceive("createOrUpdateSubscriber")
            ->once()
            ->andReturn($subscriberMock);

        $this->app->instance(
            SubscribersManager::class,
            $subscriberHandler
        );

        //When
        $this->post(
            '/message/incoming',
            [
                "Body" => "Rogue One",
                "From" => "+1234567890",
            ]
        );

        //Then
        $this->see("You have been subscribed");
    }

    /**
     * Test unsubscriptions
     *
     * @return void
     */
    public function testUnSubscriptionMessage()
    {
        //When
        $this->post(
            '/message/incoming',
            [
                "Body" => "unsub Rogue One",
                "From" => "+1234567890",
            ]
        );

        //Then
        $this->see("You have been unsubscribed");
    }


    /**
     * Test invalid commands
     *
     * @param $message Message sent by the user
     *
     * @dataProvider invalidCasesDataProvider
     *
     * @return void
     */
    public function testInvalidMessage($message)
    {
        //When
        $this->post(
            '/message/incoming',
            [
                "Body" => $message,
                "From" => "+1234567890",
            ]
        );

        //Then
        $this->see("Ups! Unknown movie.")
            ->see("The supported movies");

        $validMovies = config("app.valid_movies");
        foreach ($validMovies as $movie) {
            $this->see($movie);
        }
    }

    /**
     * Provides all possible invalid cases
     *
     * @return array
     */
    function invalidCasesDataProvider()
    {
        return array(
            ["Helps me"],
            ["Invalid Movie"],
            ["unsub Invalid Movie"],
            ["unsub"],
        );
    }
}
