<?php

use Composer\Autoload\ClassLoader;

require dirname(__DIR__) . '/vendor/autoload.php';

include_once __DIR__ . '/../vendor/autoload.php';

$classLoader = new ClassLoader();
$classLoader->addPsr4('Frontify\Tests\\', __DIR__, true);
$classLoader->register();
