<?php

namespace App;

use Services\Support\Path;

class View
{
    protected $path;
    protected $cache;
    protected $layout = null;
    protected $engine = null;
    protected $data = [];
    protected $render = [];

    public function __construct($path, $cache, Engine $engine)
    {
        $this->path = $path;
        $this->cache = $cache;
        $this->engine = $engine;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setRender($fileName, $data = [])
    {
        $template = $this->compile($fileName);

        extract($data);

        ob_start();
        include $template;
        $content = ob_get_contents();
        ob_end_clean();

        $name = substr($fileName, strripos($fileName, '.') + 1);

        return $this->render[$name] = $content;
    }

    public function render($fileName, $data = [])
    {

        $template = $this->compile($fileName);
        $layout = $this->compile($this->layout);

        extract($this->data);
        extract($this->render);

        extract($data);
        ob_start();
        include $template;
        $content = ob_get_contents();
        ob_end_clean();

        if ($this->layout) {
            ob_start();
            include $layout;
            $content = ob_get_contents();
            ob_end_clean();
        }

        return $content;
    }

    protected function getTemplate($templateName)
    {
        if (file_exists($templateName)) {
            include $templateName;

            return;
        }

        throw new \RuntimeException(sprintf('the template %s doesn\'t exist', $templateName));
    }

    protected function compile($fileName)
    {

        $templateName = $this->getPath($fileName);

        if (!file_exists($templateName)) throw new \RuntimeException(sprintf('this template doesn\'t exists %s', $templateName));

        $fileCache = $this->cache . '/' . md5($fileName) . '.php';

        if (!file_exists($fileCache) && APPLICATION_ENV != 'dev') {
            $c = $this->fileTemplate($templateName);
            file_put_contents($fileCache, $c);
        } else {
            $c = $this->fileTemplate($templateName);
            file_put_contents($fileCache, $c);
        }

        return $fileCache;
    }

    protected function fileTemplate($fileName)
    {
        $c = file_get_contents($fileName);

        return $this->engine->compileStatement($c);
    }
}
