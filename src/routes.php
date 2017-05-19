<?php

$app->mount( '/', new Controller\IndexController());
$app->mount( '/', new Controller\SecurityController());
