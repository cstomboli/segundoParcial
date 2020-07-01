<?php
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\User;
use App\models\Datos;

class UsersController 
{
    function getAll(Request $request, Response $response, $args){
       
        $rta = json_encode(Usuario::all());
        $response->getBody()->write($rta);//("Hello Tita");
        return $response;    
    }

    function add(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
             
        if(isset($_POST['email']) && isset($_POST['clave']) && isset($_POST['tipo']) && isset($_POST['legajo']) && isset($_POST['nombre'])) 
        {
            $usuario = new User();
            $usuario->email=$body['email'];
            $usuario->clave=$body['clave'];
            $usuario->tipo_id=$body['tipo'];
            $usuario->nombre=$body['nombre'];
            $usuario->legajo=$body['legajo'];

            $response->getBody()->write(json_encode($usuario->save()));
        }
        else
        {
            $response->getBody()->write("No se pudo guardar");
        }
        return $response;
    }

    
    function login(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $usuarioEmail=User::where('email', $body['email'])->get();
        $usuarioClave=User::where('email', $body['email'])->get();

        if($usuarioEmail == $usuarioClave)
        {     
            $key = 'usuario';
            $payload = array(
                "id" =>$usuarioEmail[0]->id,
                "email" => $usuarioEmail[0]->email,
                "tipo" => $usuarioEmail[0]->tipo,
                "password" => $usuarioEmail[0]->password);               
                
        }
        $response->getBody()->write(JWT::encode($payload,$key));
        return $response;
    }
}