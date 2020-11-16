<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Materia;

class MateriaController
{
    public function agregarMateria(Request $request, Response $response, $args)
    {
        $respuesta = $request->getParsedBody();
        $materia = new Materia;
        $materia->nombre = $respuesta['materia'];
        $materia->cuatrimestre = $respuesta['cuatrimestre'];//mirar si en tabla esta como pass o clave $usuario->clave
        $materia->cupos = $respuesta['cupos'];
        $rta = json_encode(array("ok" => $materia->save()));
        $response->getBody()->write($rta);
        $response->withHeader('Content-type', 'application/json');
        return $response; 
    }

}
