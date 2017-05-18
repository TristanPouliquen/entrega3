<?php

// configure your app for the production environment
echo('prod config');
$app['twig.path'] = array(__DIR__.'/../src/views');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
