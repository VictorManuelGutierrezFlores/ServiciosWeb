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
    // RUTA GET CON PARAMETRO 'NOMBRE'
    $app->get('/hola[/{name}]', function( Request $request, Response $response, $args) {
        $name = isset($args['name']) ? $args['name'] : 'mundo';
        $response->getBody()->write("Hola, $name!");
        return $response;
    });

    // Ruta con Post
    $app->post('/postmethd', function( Request $request, Response $response, $args){
        $reqPost = $request->getParsedBody();
        $val1 = $reqPost["val1"];
        $val2 = $reqPost["val2"];

        $response->getBody()->write("Valores: ".$val1." ".$val2);
        return $response;
    });

    $app->post('/testjson', function(Request $request, Response $response, $args){
        $json = '{"name": "John Doe", "age": 30, "address": {"street": "123 Main Street", "city": "San Francisco", "state": "CA", "zip": "94105"}}';
        $reqPost = $request->getParsedBody();
        $val1 = $reqPost["val1"];
        $val2 = $reqPost["val2"];
        $val3 = $reqPost["val3"];
        $val4 = $reqPost["val4"];
        $data[0]["Nombre"]=$val1;
        $data[0]["Apellidos"]=$val2;
        $data[1]["Nombre"]=$val3;
        $data[1]["Apellidos"]=$val4;
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response;
    });
    $app->run();

