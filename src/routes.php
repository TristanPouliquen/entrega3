<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () use($app) {
    $hotel = $app["orm.ems"]["grupo40"]->getRepository("Entity40\Hotel")->findAll()[0];
    $restaurant = $app["orm.ems"]["grupo37"]->getRepository("Entity37\Restaurant")->findAll()[0];
    return new Response($hotel->getName() . " - " . $restaurant->getName());
});
