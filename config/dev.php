<?php

use Silex\Provider\MonologServiceProvider;

// include the prod configuration
require __DIR__.'/prod.php';


var_dump($app);die;

// enable the debug mode
$app['debug'] = true;

/*$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/log/development.log',
));*/
