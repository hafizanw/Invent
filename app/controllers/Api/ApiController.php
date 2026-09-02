<?php

namespace App\Controllers\Api;

use Phalcon\Mvc\Controller;

class ApiController extends Controller
{
    public function healthAction()
    {
        $this->view->disable();

        $this->response->setJsonContent([
            'status'    => 'ok',
            'timestamp' => date('Y-m-d H:i:s'),
            'system'    => 'Inventory Management API',
            'version'   => '1.0.0'
        ]);

        return $this->response->send();
    }
}
