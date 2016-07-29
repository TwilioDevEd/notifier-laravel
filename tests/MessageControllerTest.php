<?php

use App\Notifications\Subscribers\MoviesNotificationsSubscriptor;
use App\Notifications\Subscribers\MessageHandler;

class MessageControllerTest extends TestCase
{
    /**
     * Endpoint for parsing incoming user sms
     *
     * @param $message User request message
     * @param $expectedCmd Command expected to be excecuted
     *
     * @dataProvider commandsDataProvider
     */
    public function testPostIncoming($message, $expectedCmd)
    {
        //Given
        $twilioRequest = [
            "Body" => $message,
            "From" => "+12345678990"
        ];

        $moviesSubscriberMock = Mockery::mock(MessageHandler::class)
            ->makePartial();
        $moviesSubscriberMock->shouldReceive($expectedCmd)
            ->once()
            ->andReturn(true);

        $this->app->instance(
            MoviesNotificationsSubscriptor::class,
            $moviesSubscriberMock
        );

        // When
        $this->call(
            "post",
            "/message/incoming",
            $twilioRequest
        );

        //Then
        $this->assertResponseOk();
    }

    /**
     * Provides all use cases
     *
     * @return array
     */
    function commandsDataProvider()
    {
        return array(
            ["Han Solo Spinoff", "subscribe"],
            ["Han Solo Spinofff", "invalid"],
            ["Help me", "help"],
            ["help", "help"],
            ["", "invalid"],
        );
    }
}
