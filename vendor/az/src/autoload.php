<?php declare(strict_types=1);

spl_autoload_register(function ($className) {
    $file = APPPATH . str_replace(['App', '\\'], ['', '/'], $className) . '.php';

    if (!is_file($file)) {        
        return false;
    }

    require_once $file;
    return true;
});
