<?php
return array(
    'home'           => array(
        'pattern'    => '/',
        'controller' => 'MySystem\\Controller\\IndexController',
        'action'     => 'index'
    ),
    'goods'          => array(
        'pattern'    => '/goods',
        'controller' => 'MySystem\\Controller\\GoodsController',
        'action'     => 'index'
    ),
    'agents'          => array(
        'pattern'    => '/agents',
        'controller' => 'MySystem\\Controller\\AgentsController',
        'action'     => 'index'
    ),
    'add_goods'      => array(
        'pattern'       => '/goods/add',
        'controller'    => 'MySystem\\Controller\\GoodsController',
        'action'        => 'add',
    ),
    'remove_goods'      => array(
        'pattern'       => '/goods/remove/{id}',
        'controller'    => 'MySystem\\Controller\\GoodsController',
        'action'        => 'remove',
    ),
    'edit_goods'      => array(
        'pattern'       => '/goods/edit/{id}',
        'controller'    => 'MySystem\\Controller\\GoodsController',
        'action'        => 'edit',
    ),
    'add_agents'      => array(
        'pattern'       => '/agents/add',
        'controller'    => 'MySystem\\Controller\\AgentsController',
        'action'        => 'add',
    ),
    'remove_agents'      => array(
        'pattern'       => '/agents/remove/{id}',
        'controller'    => 'MySystem\\Controller\\AgentsController',
        'action'        => 'remove',
    ),
    'edit_agents'      => array(
        'pattern'       => '/agents/edit/{id}',
        'controller'    => 'MySystem\\Controller\\AgentsController',
        'action'        => 'edit',
    ),
    'address'          => array(
        'pattern'    => '/address',
        'controller' => 'MySystem\\Controller\\AddressController',
        'action'     => 'index'
    ),
    'add_address'      => array(
        'pattern'       => '/address/add/{id}',
        'controller'    => 'MySystem\\Controller\\AddressController',
        'action'        => 'add',
    ),
    'edit_address'      => array(
        'pattern'       => '/address/edit/{id}',
        'controller'    => 'MySystem\\Controller\\AddressController',
        'action'        => 'edit',
    ),
    'remove_address'      => array(
        'pattern'       => '/address/remove/{id}',
        'controller'    => 'MySystem\\Controller\\AddressController',
        'action'        => 'remove',
    ),
);
?>
