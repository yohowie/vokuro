<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__)->safeLoad();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => strtolower($_ENV['DB_ADAPTER']) ?? 'mysql',
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'name' => $_ENV['DB_DBNAME'] ?? 'development_db',
            'user' => $_ENV['DB_USERNAME'] ?? 'root',
            'pass' => $_ENV['DB_PASSWORD'] ?? '',
            'port' => '3306',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
