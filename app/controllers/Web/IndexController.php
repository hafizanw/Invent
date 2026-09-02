<?php

namespace App\Controllers\Web;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->setVar('appName', 'Inventory Management System');
        $this->view->setVar('status', 'Phalcon 5 Application is Running!');
    }

    public function dbCheckAction()
    {
        $this->view->disable();
        
        try {
            /** @var \Phalcon\Db\Adapter\Pdo\Mysql $db */
            $db = $this->di->getShared('db');
            $result = $db->query("SELECT VERSION() as version")->fetch();

            $this->response->setJsonContent([
                'status'     => 'success',
                'message'    => 'Successfully connected to Local Host MySQL Database',
                'db_version' => $result['version'] ?? 'Unknown'
            ]);
        } catch (\Throwable $e) {
            $this->response->setStatusCode(500, 'Internal Server Error');
            $this->response->setJsonContent([
                'status'  => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }

        return $this->response->send();
    }
}
