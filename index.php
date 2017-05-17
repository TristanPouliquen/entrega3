<?php

$loader = require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app['debug']=false;
$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/development.log',
));
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_pgsql',
        'host'      => 'localhost',
        'dbname'    => 'grupo40',
        'user'      => 'grupo40',
        'password'  => 'grupo40',
    ),
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
    $sql1 = "SELECT DISTINCT tipo FROM Facilidades;";
    $types = $app['db']->fetchAll($sql1);
    $sql2 = "SELECT DISTINCT ciudad FROM Direcciones";
    $cities = $app['db']->fetchAll($sql2);
    $sql3 = "SELECT id, nombre FROM Hoteles";
    $hotels = $app['db']->fetchAll($sql3);
    return $app['twig']->render('index.twig', [
        'cities' => $cities,
        'types' => $types,
        'hotels' => $hotels
        ]);
});

$app->run();
