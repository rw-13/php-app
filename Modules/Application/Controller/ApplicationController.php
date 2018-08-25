<?php

namespace Modules\Application\Controller;

use Core\ViewModel;

class ApplicationController
{
    public function actionIndex()
    {
        return new ViewModel([]);
    }
}