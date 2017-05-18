<?php

// configure your app for the production environment
$app['twig.path'] = array(realpath(__DIR__.'/../src/views'));
$app['twig.options'] = array(
  'cache' => __DIR__.'/../var/cache/twig',
  'auto_reload' => true
);
var_dump($app['twig.path']);die;
