<?php

$loader = require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;


\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app['debug']=false;
$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/log/development.log',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'dbs.options' => [
        'grupo37' => [
            'driver'    => 'pdo_pgsql',
            'host'      => 'localhost',
            'dbname'    => 'grupo37',
            'user'      => 'grupo37',
            'password'  => 'grupo37',
        ],
        'grupo40' => [
            'driver'    => 'pdo_pgsql',
            'host'      => 'localhost',
            'dbname'    => 'grupo40',
            'user'      => 'grupo40',
            'password'  => 'grupo40',
        ],
    ],
]);

$app->register(new DoctrineOrmServiceProvider, [
    'orm.ems.options' => [
        'grupo37' => [
            'connection' => 'grupo37',
            'mappings' => [
                'type' => 'annotation',
                'namespace' => 'Entities\37',
                'path' => __DIR__ . '/entities/37'
            ]
        ],
        'grupo40' => [
            'connection' => 'grupo40',
            'mappings' => [
                'type' => 'annotation',
                'namespace' => 'Entities\40',
                'path' => __DIR__ . '/entities/40'
            ]
        ]
    ]
]);


$app->get('/', function () use($app) {
    $hotel = $app["orm.ems"]["grupo40"]->getRepository("Entities\40\Hotel")->findFirst();
    return new Response(json_encode($hotel));
});

$app->run();
