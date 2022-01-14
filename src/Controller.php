<?php

namespace App;

use App\App;
use PDO;
use Symfony\Component\Dotenv\Dotenv;

abstract class Controller
{
    protected $view = null;
    protected $pdo = null;
    protected $container = null;
    protected $mailer = null;
    protected $message = null;

    public function __construct()
    {
        $this->container = App::get();

        if (isset($this->container['view']))
            $this->view = $this->container['view'];

        $this->setConnect();

        $this->run();
    }

    private function run()
    {
        if (property_exists($this, 'layout')) {
            $this->view->setLayout($this->layout);
        }

        if (method_exists($this, 'init')) {
            //$this->init();
        }
    }

    private function setConnect()
    {
        $database = $this->container['connection'];

        if ($database['driver'] == 'mysql') {
            $dsn = "mysql:host={$database['host']};dbname={$database['database']};charset={$database['charset']}";
            $this->pdo = new PDO($dsn, $database['username'], $database['password']);
        }

        if ($database['driver'] == 'sqlite') {
            $this->pdo = new PDO($database['database']);
        }
    }
}
