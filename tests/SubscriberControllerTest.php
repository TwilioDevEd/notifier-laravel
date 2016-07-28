<?php

use App\Notifications\Subscribers\MoviesSubscriptor;
use App\Notifications\Subscribers\SubscribersFacade;

class SubscriberControllerTest extends TestCase
{
    /**
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

        $moviesSubscriberMock = Mockery::mock(SubscribersFacade::class)->makePartial();
        $moviesSubscriberMock->shouldReceive($expectedCmd)->once()->andReturn(true);

        $this->app->instance(
            MoviesSubscriptor::class,
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
