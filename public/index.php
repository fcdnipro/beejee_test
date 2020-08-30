<?php 
    session_start();
    require '../views/header.php'; 
?>
<?php
    require_once "../includes/startup.php";
    $db = new PDO('mysql:host=localhost;dbname=epiz_26627559_mvc_db', 'epiz_26627559', 'K7zXQ8Vkcur2O');
    $registry->offsetSet('db', $db);
    
    $template = new Template($registry);
    $registry->offsetSet ('template', $template);
    
    $router = new Router($registry);
    $registry->offsetSet('router', $router);
    $router->setPath(SITE_PATH . 'controllers');
    $router->delegate();
?>
<?php require '../views/footer.php'; ?>