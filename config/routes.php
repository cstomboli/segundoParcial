<?php
namespace Config;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsersController; 
use App\Middleware\RegistroMiddleware; //ver de agregar todos los middleware
use App\Middleware\LoginMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function($app)
{
    $app->post('/usuario', UsersController::class.':add')->add(RegistroMiddleware::class); 
    $app->post('/login', UsersController::class.':login')->add(LoginMiddleware::class); 
    $app->post('/materias', UsersController::class.':login')->add(MateriasMiddleware::class); 

    //$app->post('/login', UsuarioController::class.':login')->add(LoginMiddleware::class);
    //$app->post('/mascota', MascotaController::class.':add');

    //$app->get('/registro', usuarioController::class.':add');
    //$app->group('/usuario', function(RouteCollectorProxy $group)
    ////{
    //    $group->get('/', UsuariosController::class.':getAll');  
        
        //$group->get('/{id}', AlumnosController::class.'cambiar');
    //});

    $app->group('/localidades', function(RouteCollectorProxy $group)
    {
        $group->get('[/]', AlumnosController::class.':getAll');  //ver si esta bien
        $group->get('/{id}', AlumnosController::class.'cambiar');
    });
};