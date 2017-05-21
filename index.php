<?php

ini_set('display_errors', 0);

$loader = require_once __DIR__.'/vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app = require __DIR__.'/src/bootstrap.php';
require __DIR__.'/config/dev.php';
require __DIR__.'/src/app.php';
// coucou

$app->run();
