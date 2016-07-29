<?php

class ParseMessageTest extends TestCase
{

    public function testParseHelp()
    {
        //When
        $command = parseMessage("help me");

        //Then
        $this->assertEquals(
            "help", $command["name"],
            "Dont recognize the help command"
        );
    }

    public function testParseSuscribe()
    {
        //When
        $command = parseMessage("rogue_one");

        //Then
        $this->assertEquals(
            "subscribe", $command["name"],
            "Dont recognize the subscribe command"
        );
        $this->assertEquals(
            "Rogue One", $command["params"],
            "Dont recognize the params of subscribe command"
        );


        //When
        $command = parseMessage("Rogue One");

        //Then
        $this->assertEquals(
            "subscribe", $command["name"],
            "Subscribe is not accepting exact titles"
        );
        $this->assertEquals(
            "Rogue One", $command["params"],
            "Subscribe with exact title request is not returning right title"
        );


        //When
        $command = parseMessage("rogue_1");

        //Then
        $this->assertEquals(
            "invalid", $command["name"],
            "Give wrong answer on invalid subscriptions"
        );
    }

    public function testParseUnsub()
    {
        //When
        $command = parseMessage("unsub Rogue One");

        //Then
        $this->assertEquals(
            "unsub", $command["name"],
            "Dont recognize the unsub command"
        );
        $this->assertEquals(
            "Rogue One", $command["params"],
            "Dont recognize the unsub params"
        );

        //When
        $command = parseMessage("unsub   Rogue One");

        //Then
        $this->assertEquals(
            "unsub", $command["name"],
            "Is admiting unsub with multiple spaces"
        );
        $this->assertEquals(
            "Rogue One", $command["params"],
            "Is admiting unsub params with multiple spaces"
        );
    }

    public function testConvertToNameFormat()
    {
        $name = strNameFormat("rogue_one");

        $this->assertEquals(
            "rogue_one", $name,
            "The movie name format is not correct"
        );

        $name = strNameFormat("Rogue One");

        $this->assertEquals(
            "rogue_one", $name,
            "The movie name format is not correct with verbose text"
        );
    }
}
