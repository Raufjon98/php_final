<?php
$router = new Router();
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$router->get('/user', UserService::load()); //get users
$router->get('/file', FileService::load());  //get files
// $router->post('/user', UserService::save($_POST)); //add user (parameters: email, fullName, age, gender, password)
$router->get('/user/(\d+)', UserService::loadById(1)); //user description
// $router->delete('/user/' . $id, UserService::delete($id)); //delete user
// $router->get('/file/' . $id, FileService::loadById($id));  //file description
// $router->delete('/file/' . $id, FileService::delete($id)); // delete file
// $router->put('/user/' . $id, UserService::update($_POST, $id)); //update user description with ooptions: email, password, fullName, age, gender, id
// var_dump($uri);
var_dump($router->route($uri, $method));
// var_dump($_POST);
