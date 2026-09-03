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
        try {
            /** @var \Phalcon\Db\Adapter\Pdo\Mysql $db */
            $db = $this->di->getShared('db');
            $result = $db->query("SELECT VERSION() as version")->fetch();
 
            // Latihan DI: $this->db (magic property) VS $this->di->getShared('db')
            // manual -> harus objek yang SAMA karena 'db' didaftarkan setShared().
            $dbViaMagic  = $this->db;
            $dbViaManual = $db;
 
            $this->response->setJsonContent([
                'status'          => 'success',
                'message'         => 'Successfully connected to Local Host MySQL Database',
                'db_version'      => $result['version'] ?? 'Unknown',
                'is_same_instance' => spl_object_id($dbViaMagic) === spl_object_id($dbViaManual),
                'object_id_magic'  => spl_object_id($dbViaMagic),
                'object_id_manual' => spl_object_id($dbViaManual),
            ]);
        } catch (\Throwable $e) {
            $this->response->setStatusCode(500, 'Internal Server Error');
            $this->response->setJsonContent([
                'status'  => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }
 
        return $this->response;
    }


    public function pingAction($name = null)
    {
        $this->view->disable();
        $this->response->setContentType('text/plain');
        $this->response->setContent($name ? "pong, {$name}!" : 'pong');
        return $this->response;
    }

}
