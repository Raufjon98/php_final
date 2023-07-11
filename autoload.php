<?php

function LoadClasses($className) {
    $directories = [
            'controller/',
            'entity/',
            'service/',
            'repository/',
            'viewModel/',
            'config/'
    ];
    foreach($directories as $directory){
        $file = $directory.$className.'.php';
        if(file_exists($file)){
            require_once $file;
            return;
        }
    }
}


spl_autoload_register('LoadClasses');

