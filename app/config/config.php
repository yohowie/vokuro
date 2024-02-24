<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

use Phalcon\Config\Config;
use Phalcon\Logger\Logger;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new Config([
    'app' => [
        'viewsDir' => APP_PATH . '/views/',
        'cacheDir' => BASE_PATH .'/runtime/cache/'
    ],
    'db' => [
        'adapter'     => $_ENV['DB_ADAPTER'] ?? 'Mysql',
        'host'        => $_ENV['DB_HOST'] ?? 'localhost',
        'username'    => $_ENV['DB_USERNAME'] ?? 'root',
        'password'    => $_ENV['DB_PASSWORD'] ?? '',
        'dbname'      => $_ENV['DB_DBNAME'] ?? 'test',
        'charset'     => $_ENV['DB_CHARSET'] ?? 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => BASE_PATH . '/db/migrations/',
        'seedsDir'       => BASE_PATH . '/db/seeds/',
        // 'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'formsDir'       => APP_PATH . '/forms',
        // 'cacheDir'       => BASE_PATH . '/var/cache/',
        'baseUri'        => '/',
        'cryptSalt'      => $_ENV['APP_CRYPT_SALT'] ?? 'Phalcon',
        'publicUrl'      => $_ENV['APP_PUBLIC_URL']
    ],
    'logger' => [
        'logsDir'  => BASE_PATH .'/runtime/logs/',
        'filename' => 'app.log',
        'logLevel' => Logger::DEBUG,
    ],
    'mail' => [
        'fromName' => $_ENV['MAIL_FROM_NAME'] ?? 'Vokuro',
        'fromEmail' => $_ENV['MAIL_FROM_EMAIL'],
        'smtp' => [
            'server' => $_ENV['MAIL_SMTP_SERVER'],
            'port' => $_ENV['MAIL_SMTP_PORT'] ?? '587',
            'security' => $_ENV['MAIL_SMTP_SECURITY'] ?? 'tls',
            'username' => $_ENV['MAIL_SMTP_USERNAME'],
            'password' => $_ENV['MAIL_SMTP_PASSWORD']
        ]
    ],
    'useMail' => true,
]);
