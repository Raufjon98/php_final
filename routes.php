<?php
$router->get('/user', UserService::load());
$router->get('/file', FileService::load());
$router->get('user/{id}', UserService::loadById($id));
$router->post('/user', UserService::save($data));
$router->delete('/user/{id}', UserService::delete($id));