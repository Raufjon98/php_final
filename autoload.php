<?php
function loadController($controllerName)
{
    if (file_exists('controller/' . $controllerName . '.php'))
        require_once 'controller/' . $controllerName . '.php';
}

function loadEntity($className)
{
    if (file_exists('entity/' . $className . '.php')) {
        require_once 'entity/' . $className . '.php';
    }
}

function loadService($className)
{
    if (file_exists('service/' . $className . '.php')) {
        require_once 'service/' . $className . '.php';
    }
}

function loadRepository($className)
{
    if (file_exists('repository/' . $className . '.php')) {
        require_once 'repository/' . $className . '.php';
    }
}
function loadViewModel($className)
{
    if (file_exists('viewModel/' . $className . '.php')) {
        require_once 'viewModel/' . $className . '.php';
    }
}
function loadConfig($srcName)
{
    if (file_exists('config/' . $srcName . '.php'))
        require_once 'config/' . $srcName . '.php';
}

spl_autoload_register('loadController');
spl_autoload_register('loadEntity');
spl_autoload_register('loadService');
spl_autoload_register('loadConfig');
spl_autoload_register('loadRepository');
spl_autoload_register('loadViewModel');

