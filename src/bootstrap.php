<?php

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1',
    'assets.version_format' => '%s?version=%s',
    'assets.named_packages' => array(
        'css' => array('version' => 'css2', 'base_path' => 'assets/css'),
        'images' => array('base_path' => 'assets/img'),
        'js' => array('base_path' => 'assets/js'),
        'fonts' => array('base_path' => 'assets/fonts')
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
                [
                    'type' => 'yml',
                    'namespace' => 'Entity37',
                    'path' => __DIR__ . '/../config/doctrine/grupo37'
                ]
            ]
        ],
        'grupo40' => [
            'connection' => 'grupo40',
            'mappings' => [
                [
                    'type' => 'yml',
                    'namespace' => 'Entity40',
                    'path' => __DIR__ . '/../config/doctrine/grupo40'
                ]
            ]
        ]
    ],
    'orm.proxies_dir' => __DIR__.'/../var/cache/doctrine/proxies'
]);

return $app;
