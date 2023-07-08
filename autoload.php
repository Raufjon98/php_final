<?php
function loadController($controllerName)
{
    if (file_exists('controller/' . $controllerName . '.php'))
        require_once 'controller/' . $controllerName . '.php';
}

function loadEntity($className)
{
    if (file_exists('model/entity/' . $className . '.php')) {
        require_once 'model/entity/' . $className . '.php';
    }
}

function loadService($className)
{
    if (file_exists('model/service/' . $className . '.php')) {
        require_once 'model/service/' . $className . '.php';
    }
}

function loadRepository($className)
{
    if (file_exists('model/repository/' . $className . '.php')) {
        require_once 'model/repository/' . $className . '.php';
    }
}
function loadViewModel($className)
{
    if (file_exists('model/viewModel/' . $className . '.php')) {
        require_once 'model/viewModel/' . $className . '.php';
    }
}
function loadSrc($srcName)
{
    if (file_exists('src/' . $srcName . '.php'))
        require_once 'src/' . $srcName . '.php';
}

spl_autoload_register('loadController');
spl_autoload_register('loadEntity');
spl_autoload_register('loadService');
spl_autoload_register('loadSrc');
spl_autoload_register('loadRepository');
spl_autoload_register('loadViewModel');

