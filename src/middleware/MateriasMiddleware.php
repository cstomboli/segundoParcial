<?php
/*
namespace App\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Models\Materia;


class MateriasMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
    
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getParsedBody(); 
        $tengo=$body['materia'];
        $materia=Materia::where('materia', $tengo)->get();
        
        if($materia == '[]' )
        {
            echo("if".$materia);
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $response = new Response();
            $response->getBody()->write($existingContent);
            return $response;

        }else{
           echo("else".$materia); 
            $response = new Response();
            $response->getBody()->write("Ya existe la materia!");
            $response->withStatus(403);
            return $response;
        } 
    }
}
 */