<?php

$router = $di->getRouter();

$router->add('/confirm/{code}/{email}', [
    'controller' => 'user_control',
    'action' => 'confirmEmail',
]);

// Define your routes here
$router->add('/reset-password/{code}/{email}', [
    'controller' => 'user_control',
    'action' => 'resetPassword'
]);

$router->handle($_SERVER['REQUEST_URI']);
