<?php

use Twilio\Rest\Client;

class ConfigTest extends TestCase
{

    public function testTwilioClientEnvParams()
    {
        $this->assertEquals("TWILIO_ACCOUNT_SID", Client::ENV_ACCOUNT_SID);
        $this->assertEquals("TWILIO_AUTH_TOKEN", Client::ENV_AUTH_TOKEN);
    }
}
