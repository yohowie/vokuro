<?php
declare(strict_types=1);

use Phalcon\Crypt;
use Phalcon\Di\FactoryDefault;
use Phalcon\Encryption\Security;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Html\Escaper;
use Phalcon\Logger\Adapter\Stream as FileLogger;
use Phalcon\Logger\Logger;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\ViewBaseInterface;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Bag;
use Phalcon\Session\Manager as SessionManager;
use Vokuro\Plugins\Acl\Acl;
use Vokuro\Plugins\Auth\Auth;
use Vokuro\Plugins\Mail\Mail;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function() {
    $config = $this->getConfig();

    $view = new View();
    $view->setViewsDir($config->path('app.viewsDir'));
    $view->registerEngines([
        '.volt' => function (ViewBaseInterface $view) use($config) {
            $volt = new VoltEngine($view, $this);
            $volt->setOptions([
                'always'    => true,
                'separator' => '_',
                'path'      => $config->path('app.cacheDir'),
                'prefix'    => '',
            ]);

            return $volt;
        },
        '.phtml' => PhpEngine::class
    ]);

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->path('db.adapter');
    $params = [
        'host'     => $config->path('db.host'),
        'username' => $config->path('db.username'),
        'password' => $config->path('db.password'),
        'dbname'   => $config->path('db.dbname'),
        'charset'  => $config->path('db.charset')
    ];

    if ($config->path('db.adapter') == 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    $escaper = new Escaper();
    $flash = new Flash($escaper);
    $flash->setImplicitFlush(false);
    $flash->setCssClasses([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);

    return $flash;
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => sys_get_temp_dir(),
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});

/**
 * 设置默认命名空间
 */
$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();

    $dispatcher->setDefaultNamespace('Vokuro\Controllers');

    return $dispatcher;
});

/**
 * Logger dependency injection into the service
 */
$di->setShared('logger', function() {
    $config = $this->getConfig();

    $path = rtrim($config->path('logger.logsDir'), '\\/') . DIRECTORY_SEPARATOR;
    $adapter = new FileLogger($path . $config->path('logger.filename'));
    $logger = new Logger('messages', [
        'main' => $adapter
    ]);
    $logger->setLogLevel($config->path('logger.logLevel'));

    return $logger;
});

/**
 * 加载静态资源
 */
$di->setShared('assets', function() {
    $version = '1.0.0';

    $container = new FactoryDefault();
    $assetManager = $container->get('assets');

    $assetManager->collection('css')
        ->addCss('assets/bootstrap/dist/css/bootstrap.min.css?dc='. $version, true, false, [
            'media' => 'screen,projection',
        ])
        ->addCss('/css/style.css?dc='. $version, true, true, [
            'media' => 'screen,projection'
        ]);

    $assetManager->collection('js')
        ->addJs('assets/jquery/dist/jquery.min.js?dc='. $version, true, true)
        ->addJs('assets/bootstrap/dist/js/bootstrap.min.js?dc='. $version, true, false);

    return $assetManager;
});

$di->setShared('acl', function() {
    $filename = APP_PATH .'/config/acl.php';
    $privateResources = [];
    if (is_readable($filename)) {
        $privateResources = include $filename;
        if (!empty($privateResources['private'])) {
            $privateResources = $privateResources['private'];
        }
    }

    $acl = new Acl();
    $acl->addPrivateResources($privateResources);

    return $acl;
});

/**
 * 注册用户验证组件
 */
$di->setShared('auth', Auth::class);

$di->setShared('mail', Mail::class);

/**
 * 加密/解密
 */
$di->set('crypt', function() use($di) {
    $cryptSalt = $di->getShared('config')->path('application.cryptSalt');
    $crypt = new Crypt();
    $crypt->setKey($cryptSalt);

    return $crypt;
});

$di->set('sessionBag', function() {
    return new Bag('conditions');
});

$di->set('security', function() use($di) {
    $security = new Security();
    $security->setDI($di);

    return $security;
});
