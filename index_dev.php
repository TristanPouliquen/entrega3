<?php

ini_set('display_errors', 0);

$loader = require_once __DIR__.'/vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

require __DIR__.'/config/dev.php';
$app = require __DIR__.'/src/app.php';

$app->run();
