<?php
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Models\User;

class LoginMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody(); 
        
     /*   $usuario=User::where('email', $body['email'])->get();
        $usuario = json_decode(User::whereRaw('email = ? AND clave = ?',array($email,$password))
                                ->join('tipos','Users.tipo_id','=','tipos.Id')
                                ->get());   */

        $usuario = json_decode(User::whereRaw('email = ? AND password = ?',array($headers['email'],$headers['password']))->get());

        
        if($usuario != '[]')
        {
            //echo("if".$legajo);
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $array = array(
                "status"=>"200",
                "token"=> $existingContent
            );
            $response->getBody()->write(json_encode($array));
            return $response;

        }else{
            //echo("else".$legajo); 
            $response = new Response();
            //$response->getBody()->write("Ya existe el legajo!");
            $response->getBody()->write("Usuario no registrado");
            $response->withStatus(403);
            return $response;
        } 
    }
}