<?php
    require_once(__DIR__ . './../core/Loader.php');

    $loader = Loader::getInstance();
    $loader->addNamespacePath('Core\\',__DIR__.'/../core');
    $loader->addNamespacePath('MySystem\\',__DIR__.'/../src/MySystem');
    $loader->register();

    $app = new \Core\Application(__DIR__.'/../app/config/config.php');
    $app->run();
 ?>
