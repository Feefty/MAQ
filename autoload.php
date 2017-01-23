<?php
date_default_timezone_set("Asia/Hong_Kong");
session_start();
require_once __DIR__ .'/config.php';

/**
 * Autoloads the classes from the libraries so we don't have to
 * include it manually
 * @var [type]
 */
spl_autoload_register(function($className) {
    $namespace = str_replace("\\","/",__NAMESPACE__);
    $className = str_replace("\\","/",$className);
    $class = __DIR__ ."/libraries/". (empty($namespace) ? "" : $namespace ."/") ."{$className}.php";
    if (file_exists($class))
        require_once $class;
});

$DB = new Database($config['database']);
$Input = new Input();
$Validate = new Validation($config['database']);
$Util = new Utils($config);
