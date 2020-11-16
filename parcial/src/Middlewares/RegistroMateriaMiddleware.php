<?php
namespace App\Middlewares;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Models\Materia;
use \Firebase\JWT\JWT;

class RegistroMateriaMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $headers = $request->getParsedBody();
        $token = getallheaders();
        $token = $token['token'] ?? '';
        $resp = new Response();

        if(isset($token) && $token !="")
        {
            try
            {
                $decoded = JWT::decode($token, 'usuario', array('HS256'));
                
                if($decoded->tipo == "admin")
                {
                    if ((isset($headers['materia']) && $headers['materia']!="") 
                    && (isset($headers['cuatrimestre']) && $headers['cuatrimestre']!="" && $headers['cuatrimestre'] <= 4)
                    && (isset($headers['cupos']) && $headers['cupos']!=""))
                    {
                        $response = $handler->handle($request);
                        $existingContent = (string) $response->getBody();
                        $resp->getBody()->write($existingContent);
                    }
                }
                else
                {
                    $array = array(
                    "status" =>"404",
                    "message" => "No es un tipo de usuario válido");
                    $resp->getBody()->write(json_encode($array));
                }  
            }
            catch(\Throwable $th)
            {
                echo $th->getMessage();
            }
        }

        return $resp->withHeader('Content-type', 'application/json');
    }



}