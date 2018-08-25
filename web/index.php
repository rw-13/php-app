<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//Определяем константу корневой директории
define('ROOT', __DIR__);

session_start();

require_once ROOT . "/../Core/Application.php";
require_once ROOT . "/../Core/Db.php";
require_once ROOT . "/../Core/Router.php";
require_once ROOT . "/../Core/Pagination.php";
require_once ROOT . "/../Core/ViewModel.php";
require_once ROOT . "/../Components/ProductGenerator.php";
require_once ROOT . "/../Modules/Application/Controller/ApplicationController.php";
require_once ROOT . "/../Modules/Product/Controller/ProductController.php";
require_once ROOT . "/../Modules/Product/Model/Product.php";
require_once ROOT . "/../Modules/Product/Form/SearchForm.php";

//Точка входа в приложение
\Core\Application::run();
