<?php

$app->get('/', function () use($app) {
    $hotel = $app["orm.ems"]["grupo40"]->getRepository("Entity40\Hotel")->findFirst();
    return new Response(json_encode($hotel));
});
