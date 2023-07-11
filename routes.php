<?php
$router->get('/user', UserService::load());
$router->post('/user', UserService::save($data));