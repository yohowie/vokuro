<?php
use Phalcon\Autoload\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->setNamespaces([
    'Vokuro\Controllers' => $config->application->controllersDir,
    'Vokuro\Models'      => $config->application->modelsDir,
    'Vokuro\Forms'       => $config->application->formsDir,
    'Vokuro\Plugins'     => $config->application->pluginsDir
])->register();
