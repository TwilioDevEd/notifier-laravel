<?php

class NotificationControllerTest extends TestCase
{

    public function testIndex()
    {
        $this->visit('/')
            ->see("Episode VIII")
            ->see("Rogue One")
            ->see("Han Solo Spinoff");
    }

    public function testStore()
    {
        $this->post(
            "/",
            [
                "message" => "Test message",
                "movie" => "han_solo_spinoff",
            ]
        );

        $this->assertRedirectedToRoute("notification..index");
    }
}
