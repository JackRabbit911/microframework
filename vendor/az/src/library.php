<?php

declare(strict_types=1);

function dd(...$values)
{
    ob_start();
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        echo 'file: ', $trace[0]['file'], ' line: ', $trace[0]['line'], '<br>';
        var_dump(...$values);
    $output = ob_get_clean();

    echo (php_sapi_name() !== 'cli') ? $output : str_replace('<br>', PHP_EOL, strip_tags($output, ['<br>', '<pre>']));
    exit;
}

function container()
{
    global $container;
    return $container;
}

function render($file, $data)
{
    extract($data, EXTR_SKIP);               
    ob_start();
    include $file;
    return ob_get_clean();
}

function env(?string $key = null, $default = null)
{
    static $entries;

    if (!$entries) {
        $envfile = (is_file('../.env')) ? '../.env' : '.env'; 
        $loader = new josegonzalez\Dotenv\Loader($envfile);
        $entries = $loader->parse()->toArray();
    }

    $entry = (isset($entries[$key])) ? $entries[$key] : $default;

    if (is_string($entry)) {
        if (preg_match('/\{(.+?)\}/', $entry, $matches)) {
            $entry = $matches[1];
            $dc = get_defined_constants(true)['user'];

            if (!isset($dc[$entry])) {
                throw new Error(sprintf('Undefined constant "%s"', $entry));
            }
            
            $entry = $dc[$entry];
        }

        if (preg_match('/\[(.+?)\]/', $entry, $matches)) {
            $entry = $matches[1];
            $entry = explode(',', str_replace([' ', "'", '"'], '', $entry));
        }
    }

    return ($key) ? $entry : $entries;
}

function config(string $file, ?string $path = null, $default = null)
{
    static $cache = [];

    if (!isset($cache[$file])) {
        $array = require_once APPPATH . 'config/' . $file . '.php';
        $cache[$file] = $array;
    }
      
    return $path ? dot($cache[$file], $path, $default) : $cache[$file];
}

function dot(&$arr, $path, $default = null, $separator = '.') {
    $keys = explode($separator, $path);

    foreach ($keys as $key) {
        if (!is_array($arr) || !array_key_exists($key, $arr)) {
            $arr = &$default;
        } else {
            $arr = &$arr[$key];
        }       
    }

    return $arr;
}

function logger(string $msg, $file = 'test.log')
{
    $file = '../storage/logs/' . $file;
    $msg = date('d.m.y H:i:s') . ' ' . $msg . PHP_EOL;

    file_put_contents($file, $msg, FILE_APPEND);
}

function accept(string $headerKey, ?string $part = null): float|array
{
    function quality(string $header)
    {
        $parsed = array();
    
        $parts = explode(',', $header);
    
        // Resource light iteration
        $parts_keys = array_keys($parts);
        foreach ($parts_keys as $key) {
            $value = trim(str_replace(array("\r", "\n"), '', $parts[$key]));
    
            $pattern = '~\b(\;\s*+)?q\s*+=\s*+([.0-9]+)~';
    
            // If there is no quality directive, return default
            if (!preg_match($pattern, $value, $quality)) {
                $parsed[$value] = (float) 1;
            } else {
                $quality = $quality[2];
    
                if ($quality[0] === '.') {
                    $quality = '0'.$quality;
                }
    
                // Remove the quality value from the string and apply quality
                $parsed[trim(preg_replace($pattern, '', $value, 1), '; ')] = (float) $quality;
            }
        }
    
        return $parsed;
    }

    $headerValue = getallheaders()[$headerKey];
    $arrayAccept = quality($headerValue);
    return ($part) ? $arrayAccept[$part] ?? (float) 0 : $arrayAccept;
}
