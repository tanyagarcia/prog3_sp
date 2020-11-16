<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\ServerHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use Config\Database;
use App\Controllers\UserController;
use App\Controllers\MateriaController;
use App\Controllers\InscripcionController;
use Slim\Routing\RouteCollectorProxy;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\LoginMiddleware;
use App\Middlewares\RegistroUsuarioMiddleware;
use App\Middlewares\RegistroMateriaMiddleware;
use App\Middlewares\InscripcionMateriaMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->setBasePath('/parcial/public');

new Database;


$app->post('/login', UserController::class. ":login")->add(new LoginMiddleware())->add(new JsonMiddleware());
$app->post('/materia', MateriaController::class. ":agregarMateria")->add(new RegistroMateriaMiddleware())->add(new JsonMiddleware());
$app->post('/inscripcion/{idMateria}', InscripcionController::class. ":inscripcionMateria")->add(new InscripcionMateriaMiddleware())->add(new JsonMiddleware());

$app->group('/users', function(RouteCollectorProxy $group)
{
    $group->post('', UserController::class. ":agregarUsuario")->add(new RegistroUsuarioMiddleware())->add(new JsonMiddleware());

})->add(new JsonMiddleware());


$app->run();

?>