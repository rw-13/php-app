<?php

namespace Core;

class ViewModel
{
    private $layout;

    private $viewData = [];

    public function __construct($viewData, $layout = 'layout/layout')
    {
        $this->viewData = $viewData;
        $this->layout = $layout;
    }

    public function render($viewTemplate)
    {
        $header = $content = null;

        foreach ($viewTemplate as $widget => $key)
        {
            ob_start();
            require_once (ROOT . $key . '.php');
            $$widget = ob_get_clean();
        }

        $layout = require_once (ROOT . '/../' . $this->layout . '.php');
    }
}