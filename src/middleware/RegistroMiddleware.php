<?php
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Models\User;


class RegistroMiddleware
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
        //$usuario=User::where('email', $body['email'])->get();
        
        $email= $body['email'];
        $password= $body['clave'];

        $usuario = json_decode(User::whereRaw('email = ? AND clave = ?',array($email,$password))
                                ->join('tipos','Users.tipo_id','=','tipos.Id')
                                ->get());     
        var_dump($usuario[0]->tipo);
        if($usuario == '[]' )
        {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $response = new Response();
            $response->getBody()->write("aaa".$existingContent);
            return $response;

        }else{
          
            $response = new Response();
            $response->getBody()->write("Ya existe el legajo!");
            $response->withStatus(403);
            return $response;
        } 
    }
}