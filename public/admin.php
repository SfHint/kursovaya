<?php
require_once __DIR__ . '/../app/bootstrap.php';
$config = require __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';
require_once __DIR__ . '/../app/Controllers/PollController.php';
require_once __DIR__ . '/../app/Models/Vote.php';

$controller = new AdminController($pdo, $config);
$action = $_GET['action'] ?? 'index';

if($action === 'login') $controller->login();
elseif($action === 'logout') $controller->logout();
elseif($action === 'index') $controller->index();
elseif($action === 'create') $controller->create();
elseif($action === 'edit') $controller->edit();
elseif($action === 'delete') $controller->delete();
elseif($action === 'results') $controller->results();
else { header('HTTP/1.0 404 Not Found'); echo 'Not found'; }
