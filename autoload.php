<?php
function loadController($controllerName)
{
    if (file_exists('controller/' . $controllerName . '.php'))
        require_once 'controller/' . $controllerName . '.php';
}

function loadModel($className)
{
    if (file_exists('model/' . $className . '.php')) {
        require_once 'model/' . $className . '.php';
    }
}


function loadSrc($srcName)
{
    if (file_exists('src/' . $srcName . '.php'))
        require_once 'src/' . $srcName . '.php';
}

spl_autoload_register('loadController');
spl_autoload_register('loadModel');
spl_autoload_register('loadSrc');

