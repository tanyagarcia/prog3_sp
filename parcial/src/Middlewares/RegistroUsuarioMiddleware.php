<?php
namespace App\Middlewares;

use Slim\Psr7\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Models\User;

class RegistroUsuarioMiddleware
{
    
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $headers = $request->getParsedBody();
        $resp = new Response();

        if ((isset($headers['nombre']) && $headers['nombre']!="") 
        && (isset($headers['clave']) && $headers['clave'] !="" && $headers['clave'] >= 4)
        && (isset($headers['tipo'])&& $headers['tipo']!="")
        && (isset($headers['email'])&& $headers['email']!=""))
        {
            if ($headers['tipo'] == "alumno" || $headers['tipo'] == "profesor" || $headers['tipo'] == "admin")
            {
                $email =  $headers['email'];
                $nombre =  $headers['nombre'];
                $usuarioEncontrado = json_decode(User::where('email',array($email))
                ->where('nombre',array($nombre))
                ->get());
                
                if($usuarioEncontrado == [])
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
                    "mensaje" => "No es un tipo de usuario válido"
                );
                $resp->getBody()->write(json_encode($array));
            }  
        }

        return $resp->withHeader('Content-type', 'application/json');
    }

}