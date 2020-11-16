<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use \Firebase\JWT\JWT;

class UserController
{
    public function agregarUsuario(Request $request, Response $response, $args)
    {
        
        $respuesta = $request->getParsedBody();
        $usuario = new User;
        $usuario->nombre = $respuesta['nombre'];
        $usuario->clave = $respuesta['clave'];
        $usuario->tipo = $respuesta['tipo'];
        $usuario->email = $respuesta['email'];
        $rta = json_encode(array("ok" => $usuario->save()));
        $response->getBody()->write($rta);
        $response->withHeader('Content-type', 'application/json');
        return $response;
        
    }

    public function login(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $clave = $body['clave'];
        $email = $body['email'];

        $usuarioEncontrado = json_decode(User::where('clave',array($clave))
        ->where('email',array($email))
        ->get());
        
        $payload = array(
            "nombre" => $usuarioEncontrado[0]->nombre,
            "clave" => $usuarioEncontrado[0]->clave,
            "tipo" => $usuarioEncontrado[0]->tipo,
            "email" =>$usuarioEncontrado[0]->email);
        
        $response->getBody()->write(JWT::encode($payload, 'usuario'));
        return $response->withHeader('Content-type', 'application/json');
    }
}