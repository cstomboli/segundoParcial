<?php

use Slim\App;
use App\middleware\AfterMiddleware;
use App\middleware\LoginMiddleware;
use App\middleware\MateriasMiddleware;
use App\middleware\RegistroMiddleware;


return function(App $app){

    $app->addbodyParsingMiddleware();

    $app->add(new AfterMiddleware());
    $app->add(new LoginMiddleware());
    //$app->add(new MascotaMiddleware());
    $app->add(new RegistroMiddleware());
   // $app->add(new MateriasMiddleware());

    // $app->add(BeforeMiddleware::class);
};