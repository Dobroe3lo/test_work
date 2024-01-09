<?php

namespace App\Controller;

use App;
use Psr;
use Symfony\Component;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{
    private Psr\EventDispatcher\EventDispatcherInterface $_eventDispatcher;

    public function __construct(Psr\EventDispatcher\EventDispatcherInterface $eventDispatcher, Psr\Log\LoggerInterface $logger)
    {
        $this->_eventDispatcher = new App\Decorator\LoggingEventDispatcher($eventDispatcher, $logger);
    }

    #[Route('/api/test/event', name: 'test_event')]
    public function index(Component\HttpFoundation\Request $request): Component\HttpFoundation\Response
    {
        $message = $request->get('message');
        if (empty($message)) {
            return $this->_response('Сообщение не передано');
        }

        $this->_eventDispatcher->dispatch(new App\Event\TestEvent($message));
        return $this->_response('Успешно');
    }

    private function _response(string $message): Component\HttpFoundation\Response
    {
        return new Component\HttpFoundation\Response($message);
    }
}
