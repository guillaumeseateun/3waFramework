<?php

namespace Framework;

use PDO;
use Symfony\Component\Dotenv\Dotenv;

abstract class Controller
{
    protected $view = null;
    protected $pdo = null;
    protected $container = null;
    protected $mailer = null;
    protected $message = null;
    protected $twig = null;

    public function __construct()
    {
        $this->container = App::get();

        if (isset($this->container['twig']))
            $this->twig = $this->container['twig'];

        $this->run();
    }

    private function run()
    {
        if (property_exists($this, 'layout')) {
            $this->view->setLayout($this->layout);
        }

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }
}
