<?php
namespace App\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\Materia;
use App\models\Datos;

class MateriaController 
{
    function getAll(Request $request, Response $response, $args){
       
        $rta = json_encode(Usuario::all());
        $response->getBody()->write($rta);//("Hello Tita");
        return $response;    
    }

    function add(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
             
        if(isset($_POST['materia']) && isset($_POST['cuatrimestre']) && isset($_POST['vacantes']) && isset($_POST['profesor']) ) 
        {
            $usuario = new Materia();
            $usuario->materia=$body['materia'];
            $usuario->cuatrimestre=$body['cuatrimestre'];
            $usuario->vacantes=$body['vacantes'];
            $usuario->profesor_id=$body['profesor'];
            

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