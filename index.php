<?php
session_start();
include 'db_connection.php';
// include 'views/add_akun.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'menu';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once 'controllers/' . ucfirst($controller) . 'Controller.php';

$controllerName = ucfirst($controller) . 'Controller';
$controller = new $controllerName();
$controller->$action();
?>