<?php
require_once 'service/ValidationService.php';
$router = new Router();
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->get('/user', 'UserService::load');
$router->get('/user/{id}', 'UserService::loadById');
$router->post('/user', 'UserService::save');
$router->put('/user', 'UserService::update');  
$router->delete('/user/{id}', 'UserService::delete');
$router->get('/file/{id}', 'FileService::loadById');
$router->get('/file', 'FileService::load');
$router->post('/file', 'FileService::save');
$router->put('/file', 'FileService::update');
$router->delete('/file/{id}', 'FileService::delete');
$router->get('/directory/{id}', 'DirectoryService::loadById');
$router->post('/directory', 'DirectoryService::addDirectory');
$router->put('/directory', 'DirectoryService::renameDirectory'); 
$router->delete('/directory/{id}', 'DirectoryService::delete');
$router->get('/files/share/{id}', 'FileAccessService::loadAccess');
$router->delete('/files/share/{id}/{user_id}', 'FileAccessService::delete');
$router->post('/fileAccess', 'FileAccessService::save');

$routeInfo = $router->route($uri, $method);
$service = $routeInfo['service'];
$params = $routeInfo['params'];
[$serviceClass, $serviceMethod] = explode('::', $service);
$res = call_user_func_array([$serviceClass, $serviceMethod], $params);
var_dump($res);
