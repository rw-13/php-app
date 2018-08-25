<?php

namespace Core;

class Application {
    public static function run()
    {
        $router = new \Core\Router();
        $segmentURI = $router->getUri();
        $requestArg = $router->getParams();

        $controller = ucfirst(array_shift($segmentURI));
        $action = ucfirst(array_shift($segmentURI));

        $controllerName = null;
        $actionName = null;

        switch ($controller) {
            case '':
                $controller = 'Application';
                $action = 'Index';
                break;
            default:
                $pattern = '/[\?||&][a-zA-Z0-9\-_=&%]+/';
                $action = preg_replace($pattern, '', $action);
                //$action = explode('?', $action);
                //$action = array_shift($action);
                break;
        }

        $controllerName = 'Modules\\' . $controller . '\\Controller\\' . $controller . 'Controller';
        $actionName = 'action' . $action;

        if (class_exists($controllerName))
        {
            $controllerObj = new $controllerName();
        } else {
            $host = $_SERVER['HTTP_HOST'];
            $uri = '/product/list';
            header("Location: http://$host");
        }

        if (method_exists($controllerObj, $actionName))
        {
            $viewTemplate = [
                'header' => '/../Modules/'.$controller.'/Views/header',
                'content' => '/../Modules/'.$controller.'/Views/'.lcfirst($action),
            ];
            $view = $controllerObj->$actionName($requestArg);
            $view->render($viewTemplate);
        } else {
            print 'The Class\'s Method \'' . $actionName. '\' isn\'t exist';
        }
    }

}