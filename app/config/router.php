<?php

$router = $di->getRouter();

// Define your routes here
$router->add('/reset-password/{code}/{email}', [
    'controller' => 'user_control',
    'action' => 'resetPassword'
]);

$router->handle($_SERVER['REQUEST_URI']);
