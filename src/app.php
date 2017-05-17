<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider());

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
                [
                    'type' => 'annotation',
                    'namespace' => 'Entity\grupo37',
                    'path' => __DIR__ . '/Entity/grupo37'
                ]
            ]
        ],
        'grupo40' => [
            'connection' => 'grupo40',
            'mappings' => [
                [
                    'type' => 'annotation',
                    'namespace' => 'Entity\grupo40',
                    'path' => __DIR__ . '/Entity/grupo40'
                ]
            ]
        ]
    ]
]);

require __DIR__.'/routes.php';

return $app;
