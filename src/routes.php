<?php

$app->mount( '/', new Controller\IndexController());
$app->mount( '/', new Controller\SecurityController());
$app->mount( '/hotel', new Controller\HotelController());
$app->mount( '/restaurant', new Controller\RestaurantController());
