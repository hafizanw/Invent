<?php

namespace App\Middleware;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class AuthMiddleware extends Injectable
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Example auth check middleware logic
        return true;
    }
}
