<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Twilio\Rest\Client;

class BasicTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->see('Laravel 5');
    }


    public function testTwilioClientEnvParams()
    {
        $this->assertEquals("TWILIO_ACCOUNT_SID", Client::ENV_ACCOUNT_SID);
        $this->assertEquals("TWILIO_AUTH_TOKEN", Client::ENV_AUTH_TOKEN);
    }
}
