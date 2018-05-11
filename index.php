<?php

require __DIR__.'/vendor/autoload.php';

$http = require __DIR__.'/src/config/http.php';
$services = require __DIR__.'/src/config/services.php';

$request = \App\Http\Request::create();
$container = new \App\Container($services);
$response = (new \App\Http\Pipeline($container, $http))->run($request);

$response->send();