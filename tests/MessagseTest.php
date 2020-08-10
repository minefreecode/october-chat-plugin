<?php namespace alekseypavlov\chat\Tests\Models;

use alekseypavlov\Chat\Models\Message;
use PluginTestCase;

class MessageTest extends PluginTestCase
{
    public function testGetMessages()
    {
        $messages =  Message::orderBy('id')->with('user')->get();
        $this->assertIsArray($messages);
    }
}
