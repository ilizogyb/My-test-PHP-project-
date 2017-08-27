<?php
return array(
    'mode'        => 'dev',
    'routes'      => include('routes.php'),
    'main_layout' => __DIR__.'/../../src/MySystem/Views/layout.html.php',
    'pdo'         => array(
      'dns'      => 'mysql:dbname=mysystem;host=localhost',
      'user'     => 'root',
      'password' => '52651Ihor'
    )
);
?>
