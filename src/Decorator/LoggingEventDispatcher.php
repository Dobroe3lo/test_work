<?php

namespace App\Decorator;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class LoggingEventDispatcher implements EventDispatcherInterface
{

    private EventDispatcherInterface $_eventDispatcher;
    private LoggerInterface          $_logger;

    public function __construct(EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->_eventDispatcher = $eventDispatcher;
        $this->_logger          = $logger;
    }

    /**
     * @param object $event
     * @return object|void
     */
    public function dispatch(object $event): mixed
    {
        $eventClassName = get_class($event);
        $this->_logger->info("Dispatching event: {$eventClassName}");
        $result = $this->_eventDispatcher->dispatch($event);
        $this->_logger->info("Event dispatched: {$eventClassName}");

        return $result;
    }
}