<?php

namespace Framework;

class Request
{

    protected $uri = null;
    protected $method = null;
    protected $headers = [];
    protected $params = [];

    public function __construct()
    {
        $this->uri = filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_STRING);
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->headers = apache_request_headers();

        if ($this->isPost()) {
            $this->params = array_merge($this->params, $_POST);
        }
    }

    public function getURI()
    {
        return $this->uri;
    }


    public function getHeaders()
    {
        return $this->headers;
    }

    public function getParams()
    {
        return $this->params;
    }


    public function isGet()
    {
        return ($this->method === "GET");
    }


    public function isPost()
    {
        return ($this->method === "POST");
    }

    public function getVerb()
    {
        if ($this->isPost()) {

            if (!empty($_POST['_method'])) {
                switch (strtolower($_POST['_method'])) {
                    case 'put':
                        $this->method = 'PUT';
                        break;
                    case 'patch':
                        $this->method = 'PATCH';
                        break;
                    case 'delete':
                        $this->method = 'DELETE';
                        break;
                    default:
                        $this->method = 'POST';
                }
            }
        }

        return $this->method;
    }
}
