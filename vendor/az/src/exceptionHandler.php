<?php

declare(strict_types=1);

error_reporting(E_ALL);

function errorLogger(Throwable $e)
{
    $logFile = '../storage/logs/error.log';

    $str = date('d.m.y H:i:s') 
        . ' "' . $e->getMessage()
        . '" file: ' . $e->getFile()
        . ' line: ' . $e->getLine()
        . PHP_EOL;

    file_put_contents($logFile, $str, FILE_APPEND);
}

function myExceptionHandler ($e)
{
    errorLogger($e);
    http_response_code(500);

    if (filter_var(ini_get('display_errors'),FILTER_VALIDATE_BOOLEAN)) {
        if (accept('Accept', 'text/html') == 1) {
            echo '<h3>' . get_class($e) . '</h3>';
            var_dump($e);
        } else {
            $err = new stdClass;
            $err->status = 'error';
            $err->message = $e->getMessage();
            $err->file = $e->getFile();
            $err->line = $e->getLine();
    
            echo json_encode($err, JSON_UNESCAPED_SLASHES);
        }
    } else {
        echo "<h1>500 Internal Server Error</h1>
              An internal server error has been occurred.<br>
              Please try again later.";
    }

    exit;
}

set_exception_handler('myExceptionHandler');

set_error_handler(function ($level, $message, $file = '', $line = 0)
{
    throw new ErrorException($message, 0, $level, $file, $line);
});

register_shutdown_function(function ()
{
    $error = error_get_last();

    if ($error !== null) {
        $e = new ErrorException(
            $error['message'], 0, $error['type'], $error['file'], $error['line']
        );
        myExceptionHandler($e);
    }
});
