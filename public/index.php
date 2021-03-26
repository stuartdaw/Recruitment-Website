<?php

//Front controller

// Autoload using composer tool
require_once '../vendor/autoload.php';

// Error Handling
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

// Create new router so it handle URL requests
$router = new Core\Router();

//Get URL to process
$url = $_SERVER['QUERY_STRING'];
/*echo "<p>URL: " . $url . "</p>";
echo "<pre>";
var_dump($_GET);
echo "</pre>";*/

// add routes to be handled by regular expressions
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('Admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('Admin/password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset', 'namespace' => 'Admin']);
//$router->add('{controller}/{action}?{email}');


$router->dispatch($_SERVER['QUERY_STRING']);

