<?php
    spl_autoload_register(function ($class_name) {
    include "../classes/" . $class_name . '.php';
        
    }); 
        
    
    error_reporting (E_ALL);
    if (version_compare(phpversion(), '5.1.0', '<') == true) {die ('PHP5.1 Only');}
    define ('DIRSEP', DIRECTORY_SEPARATOR);

    $site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
    define ('SITE_PATH', $site_path);
    
    $registry = new Registry;
?>