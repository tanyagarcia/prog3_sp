<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Inscripcione;
use App\Models\Materia;

class InscripcionController
{
    public function inscripcionMateria(Request $request, Response $response, $args)
    {
        $respuesta = $request->getParsedBody();
        $id = $args['idMateria'];
        $materiaCupo = json_decode(Materia::where('id', $id)
        ->where('cupos','>',0)
        ->get());
        // if($materiaCupo[0]->cupos != 0)
        // {
        //     $inscripcion = new Inscripcione;
        //     $inscripcion->id_materia = $materiaCupo[0]->id;
        //     //$inscripcion->id_alumno = $respuesta['cuatrimestre'];
        //     $rta = json_encode(array("ok" => $materia->save()));
        // }
        
        $response->getBody()->write($rta);
        $response->withHeader('Content-type', 'application/json');
        return $response; 
    }

}


