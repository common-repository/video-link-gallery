<?php
if (!function_exists('coderey_autoload')) {
    function coderey_autoload($namespacePrefix, $dir)
    {
        spl_autoload_register(function($className) use ($namespacePrefix, $dir) {
            if (strpos($className, $namespacePrefix) === 0) {
                $classFile = str_replace("\\", DIRECTORY_SEPARATOR, substr($className, strlen($namespacePrefix))) . '.php';
                require_once $dir . DIRECTORY_SEPARATOR . $classFile;
            }
        });
    }
}
