<?php
    function __autoload($class_name){
        $filename = strtolower($class_name) . '.php';
        $file = '../classes/' . $filename;
        if (file_exists($file) == false) {
            return false;
        }
        include ($file);
    }
    
    error_reporting (E_ALL);
    if (version_compare(phpversion(), '5.1.0', '<') == true) {die ('PHP5.1 Only');}
    define ('DIRSEP', DIRECTORY_SEPARATOR);

    $site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
    define ('SITE_PATH', $site_path);
    
    $registry = new Registry;
?>