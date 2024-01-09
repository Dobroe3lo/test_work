<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TestEvent extends Event
{
    private string $_message;

    public function __construct(string $message)
    {
        $this->_message = $message;
    }

    public function getMessage(): string
    {
        return $this->_message;
    }
}