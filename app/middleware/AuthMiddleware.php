<?php

namespace App\Middleware;

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class AuthMiddleware extends Injectable
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Whitelist: route yang TIDAK butuh login (halaman login itu sendiri, dll)
        $publicRoutes = [
            'auth' => ['login', 'doLogin'],
        ];

        if (isset($publicRoutes[$controller]) && in_array($action, $publicRoutes[$controller])) {
            return true; // lolos, tidak perlu cek session
        }

        if (!$this->session->has('auth')) {
            // Belum login -> hentikan eksekusi action, redirect ke halaman login
            $this->response->redirect('/login');
            $dispatcher->forward([
                'controller' => 'auth',
                'action'     => 'login',
            ]);

            return false; // WAJIB return false -> memberitahu Dispatcher: BATALKAN action asli
        }

        return true;
    }
}
