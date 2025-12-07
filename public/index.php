<?php
require_once __DIR__ . '/../app/bootstrap.php';
$config = require __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/Controllers/PollController.php';

$controller = new PollController($pdo, $config);
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if($action === 'index') $controller->index();
elseif($action === 'show' && $id) $controller->show((int)$id);
elseif($action === 'vote' && $id && $_SERVER['REQUEST_METHOD']==='POST') $controller->vote((int)$id);
else { header('HTTP/1.0 404 Not Found'); echo 'Not found'; }
