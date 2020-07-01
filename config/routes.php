<?php
namespace Config;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsersController; 
use App\Middleware\RegistroMiddleware; //ver de agregar todos los middleware
use App\Middleware\LoginMiddleware;
use App\Middleware\MateriasMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function($app)
{
    $app->post('/usuario', UsersController::class.':add')->add(RegistroMiddleware::class); 
    $app->post('/login', UsersController::class.':login')->add(LoginMiddleware::class);  
    
    $app->group('/materias', function(RouteCollectorProxy $group)
    {
        $group->post('/', MateriaController::class.':add')->add(MateriasMiddleware::class); 
        $group->get('/', MateriaController::class.':getAll');
        $group->get('/{id}', MateriaController::class.':mostrar');
        $group->put('/{id}', MateriaController::class.':add');
        $group->put('/{id}/{profesor}', MateriaController::class.':add');
    });
    

    $app->group('/localidades', function(RouteCollectorProxy $group)
    {
        $group->get('[/]', AlumnosController::class.':getAll');  //ver si esta bien
        $group->get('/{id}', AlumnosController::class.'cambiar');
    });
};