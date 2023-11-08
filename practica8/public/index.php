<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
   
    require __DIR__ . '/../vendor/autoload.php';

    $app = AppFactory::create();
    $app->setBasePath('/serviciosweb/practica8');

    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hola mundo");
        return $response;
    });
    $app->run();
?>