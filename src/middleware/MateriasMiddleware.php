<?php
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Models\Materia;
use App\Models\User;

class MateriasMiddleware
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
        $body = getallheaders();
        $token = $body['token'];
        $decoded = JWT::decode($token, 'usuario', array('HS256'));
        $usuario = json_decode(User::whereRaw('email = ? AND password = ?',array($decoded->email,$decoded->password))->get());
        
        if ($usuario[0]->tipo == 3)    
        {
            $materia=Materia::where('materia', $body['materia'])->get();
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $response = new Response();
            $response->getBody()->write($existingContent);
            return $response;
        }
        else
        {
            $response = new Response();
            $response->getBody()->write("Ya existe la materia!");
            $response->withStatus(403);
            return $response;
        } 
    }
}