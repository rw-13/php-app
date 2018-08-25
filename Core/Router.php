<?php

namespace Core;

use Modules\Product\Controller;

class Router
{
    private $uri;

    public function getUri()
    {
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->uri = explode('/', $this->uri);

        return $this->uri;
    }

    //Возвращает массив параметров, переданных в запросе
    public function getParams() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params = $_POST;
            return $params;
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $params = $_GET;
            return $params;
        } else {
            $params = null;
            return null;
        }
    }
}