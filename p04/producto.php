<?php
	//header("Content-Type: text/xml; charset=UTF-8\r\n");
    ini_set("log_errors", 1);
    ini_set("error_log", "reportes/php-error-producto.log");

	require_once 'vendor/autoload.php';
    //require_once 'nusoap/lib/nusoap.php';		//PHP v7.4.x o inferior
    
    /**
    *    CREACIÓN Y CONFIGURACIÓN DEL OBJETO QUE DEFINIRÁ EL SERVICIO WEB TIPO SOAP
    */
    $server = new soap_server();
    /*
        configureWSDL('Nombre del Servicio', 'targetNamespace');
        
        targetNamespace: Hacemos que el esquema que estamos creando tenga asociado un espacio 
                        de nombres propio (target namespace). Para ello se puede utilizar el 
                        atributo targetNamespace del elemento "schema":
    */
    $server->configureWSDL('WebServicesBUAP', 'urn:buap_api');
    $server->soap_defencoding = 'UTF-8';
	$server->decode_utf8 = false;
	$server->encode_utf8 = true;

    /**
     * CREACION DE VARIABLES DE ENTORNO
     */
    //ISBN CATEGORIZADO
    $Products = array(
        'libros' => [
            'LIB001' => 'Pedro Paramo',
            'LIB002' =>  'Odisea',
            'LIB003' => 'Metamorfosis'
        ],
        'comics' => [
            'COM001'
                => 'Flashpoint',
            'COM002'  
                => 'Iron Man',
            'COM003' =>
                'Spider Man Ultimate',
        ],
        'mangas' => [
            'MAN001' => 'Akira 2',
            'MAN002' => 'One Piece',
            'MAN003' =>  'Akira Omen']
        
    );
    // ISB SIN CATEGORIAS
    $Detalles = array(
        'LIB001' => [
            'Autor' => 'Varios',
            'Titulo' => 'Biblia',
            'Editorial' => 'Reina Valera',
            'Fecha' => 1985,
            'Precio' => 350.22,
            'Oferta' => false
        ],
        'LIB002' => [
            'Autor' => 'Varios',
            'Titulo' => 'Odisea',
            'Editorial' => 'Reina Val',
            'Fecha' => 1975,
            'Precio' => 3545.00,
            'Oferta' => false
        ],
        'LIB003' => [
            'Autor' => 'Varios',
            'Titulo' => 'Metamorfosis',
            'Editorial' => 'Reina',
            'Fecha' => 1935,
            'Precio' => 350.22,
            'Oferta' => false
        ],
        'COM001'  => [
            'Autor' => 'Victor Gutierrez',
            'Titulo' => 'Flashpoint',
            'Editorial' => 'DC',
            'Fecha' => 2002,
            'Precio' => 780.99,
            'Oferta' => true
        ],
        'COM002'  => [
            'Autor' => 'Victor Gutierrez',
            'Titulo' => 'Iron Man',
            'Editorial' => 'Marvel',
            'Fecha' => 2000,
            'Precio' => 780.99,
            'Oferta' => true
        ],
        'COM003' => [
            'Autor' => 'Victor 3',
            'Titulo' => 'Spider Man Ultimate',
            'Editorial' => 'Marvel',
            'Fecha' => 2000,
            'Precio' => 780.99,
            'Oferta' => true
        ],
        'MAN001' =>  [
            'Autor' => 'Akira 2',
            'Titulo' => 'One Piece',
            'Editorial' => 'Toei',
            'Fecha' => 1999,
            'Precio' => 178.99,
            'Oferta' => false
        ],
        'MAN002' => [
            'Autor' => 'Akira Omen',
            'Titulo' => 'Pokemon',
            'Editorial' => 'Toei',
            'Fecha' => 2005,
            'Precio' => 178.99,
            'Oferta' => true
        ],
        'MAN003' =>  [
            'Autor' => 'Akira Omen',
            'Titulo' => 'One Punch-man',
            'Editorial' => 'Toei',
            'Fecha' => 2007,
            'Precio' => 178.99,
            'Oferta' => false
        ]
    );
    // CODIGOS DE ERRORES
    $responseCodes = array(
        200 => 'Categoría encontrada exitosamente.',
        201 => 'ISBN encontrado exitosamente.',
        300 => 'Categoría no encontrada.',
        301 => 'ISBN no encontrado.',
        500 => 'Usuario no reconocido.',
        501 => 'Password no reconocido.',
        999 => 'Error no identificado'
    );
    // USERS
    $fictionalUsers = array(
        'pruebas1' => 'de88e3e4ab202d87754078cbb2df6063', //12345678a
        'pruebas2' => '6796ebbb111298d042de1a20a7b9b6eb', //12345678b
        'pruebas3' => 'f7e999012e3700d47e6cb8700ee9cf19', //12345678c
    );

    $paqeuetes = array(
        'paquete1'=>250,
        'paquete2'=>400,
        'paquete3'=>690,
        'paquete4'=>1100,
        'paquete5'=>1492,
        'paquete6'=>2480,
        'paquete7'=>7180,
        'paquete8'=>7500,
        'paquete9'=>13000,
        'paquete10'=>36000,
        'paquete11'=>50000,
    );
    

    /**
    *    REGISTRO DE OPERACIONES EN LA INTERFAZ DEL SERVICIO (WSDL)
    */
    // FUNCION GETPROD()
    $server->register( 'getProd',                               // Nombre de la operación (método)
                        array('user' => 'xsd:string',
                            'pass' => 'xsd:string',
                            'categoria' => 'xsd:string'),     // Lista de parámetros; varios de tipo simple o un tipo complejo
                        array('return' => 'tns:RespuestaGetProd'),        // Respuesta; de tipo simple o de tipo complejo
                        'urn:producto',                         // Namespace para entradas (input) y salidas (output)
                        'urn:producto#getProd',                 // Nombre de la acción (soapAction)
                        'rpc',                                  // Estilo de comunicación (rpc|document)
                        'encoded',                              // Tipo de uso (encoded|literal)
                        'Nos da una lista de productos de cada categoría.'  // Documentación o descripción del método
                    );

    //FUNCION GETDATAILS
    $server->register( 'getDetails',                        // NOMBRE DE LA FUNCION
                        array('user' => 'xsd:string',
                            'pass' => 'xsd:string',
                            'isbn' => 'xsd:string'),
                        array('return' => 'tns:RespuestaGetDetails'),
                        'urn:detalles',                     //NAMESPACE DE LA ACCION
                        'urn:detalles#getDatails',          //NOMBRE DE LA ACCION(soapAction)
                        'rpc',                              //ESTILO DE COMUNICACION (rpc|document)
                        'encoded',                          //TIPO DE USO (encoded|literal)
                        'Devuelve detalles especificos de un recurso literario'        //DESCRIPCION DEL METODO
                );
    // ESTRUCTURA COMPLEJA PARA PRODUCTS
    $server->wsdl->addComplexType(
        'RespuestaGetProd',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'code' => [ 'name' => 'code', 'type' => 'xsd:string' ],
            'message' => [ 'name' => 'message', 'type' => 'xsd:string' ],       
            'data' => [ 'name' => 'data', 'type' => 'xsd:string' ],       
            'status' => [ 'name' => 'status', 'type' => 'xsd:string' ]        
        )
    );
    // ESTRUCTURA COMPLEJA PARA DETAILS
    $server->wsdl->addComplexType(
        'RespuestaGetDetails',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'code' => [ 'name' => 'code', 'type' => 'xsd:string' ],
            'message' => [ 'name' => 'message', 'type' => 'xsd:string' ],       
            'data' => [ 'name' => 'data', 'type' => 'xsd:string' ],       
            'status' => [ 'name' => 'status', 'type' => 'xsd:string' ],
            'oferta' => [ 'name' => 'oferta', 'type' => 'xsd:boolean']   
        )
    );

    /**
    *    IMPLEMENTACION DE FUNCIONES
    */
// FUNCION GETPROD
function getProd($user, $pass, $categoria)
{
    $response = '';
    $fictionalUsers = $GLOBALS['fictionalUsers'];
    $responseCodes = $GLOBALS['responseCodes'];

    if (array_key_exists($user, $fictionalUsers)) {
        if ($fictionalUsers[$user] == md5($pass)) {
            // VERITIFICACION DE CAMPO NO VACIO
            if ($categoria != '') {
                switch ($categoria) {
                    case 'libros':
                        /**$respuesta = join("|", array("El señor de los anillos",
                        "Los límites de la Fundación",
                        "The Rails Way"));*/
                        $Products = $GLOBALS['Products'];
                        $libros = $Products['libros'];
                        $response = array(
                            'code' => '200',
                            'message' => $responseCodes[200],
                            'data' => json_encode($libros, JSON_PRETTY_PRINT),
                            'status' => 'success'
                        );
                        break;
                    case 'comics':
                        /***$response= join("|", array("Civil War",
                            "Ultimate Spiderman",
                            "Flashpoint"));*/
                        $Products = $GLOBALS['Products'];
                        $comics = $Products['comics'];
                        $response = array(
                            'code' => '200',
                            'message' => $responseCodes[200],
                            'data' => json_encode($comics, JSON_PRETTY_PRINT),
                            'status' => 'success'
                        );
                        break;
                    case 'mangas':
                        /**$response= join("|", array("Nichijou",
                            "Attack On Titan",
                            "Mushuko Tensei"));**/
                        $Products = $GLOBALS['Products'];
                        $mangas = $Products['mangas'];
                        $response = array(
                            'code' => '200',
                            'message' => $responseCodes[200],
                            'data' => json_encode($mangas, JSON_PRETTY_PRINT),
                            'status' => 'success'
                        );
                        break;
                    default:
                    // RESPUESTA CATEGORIA NO ENCONTRADA
                        $response = array(
                            'code' => '300',
                            'message' => $responseCodes[300],
                            'data' => '',
                            'status' => 'error'
                        );
                        error_log('categoria: ' . $categoria);
                        error_log('error: ' . $response);
                        break;
                }
            } else {
                // RESPUESTA A ESPACIO EN BLANCO
                $response = array(
                    'code' => '999',
                    'message' => $responseCodes[999],
                    'data' => '',
                    'status' => 'error'
                );
            }
        } else {
            // RESPUESTA CONTRASEÑA INCORRECTA
            $response = array(
                'code' => '501',
                'message' => $responseCodes[501],
                'data' => '',
                'status' => 'error'
            );
        }
    } else {
        // USUARIO NO EXISTENTE
        $response = array(
            'code' => '500',
            'message' => $responseCodes[500],
            'data' => '',
            'status' => 'error'
        );
    }



    return $response;
}

//FUNCION GETDATAILS
function getDetails($user, $pass, $isbn) {
    $response = '';
    $fictionalUsers = $GLOBALS['fictionalUsers'];
    $responseCodes = $GLOBALS['responseCodes'];

    if ( array_key_exists($user, $fictionalUsers) ) {
        if( $fictionalUsers[$user] == md5($pass)){
            // VERITIFICACION DE CAMPO NO VACIO
            if ($isbn != '') {
                // Busca el recurso en el array `Detalles`
                $detalles = $GLOBALS['Detalles'];
                if (array_key_exists($isbn, $detalles)) {
                    $response = array(
                        'code' => '201',
                        'message' => $responseCodes[201],
                        'data' => json_encode($detalles[$isbn], JSON_PRETTY_PRINT),
                        'status' => 'success'
                    );
                    }else{
                        // RESPUESTA ISBN NO ENCONTRADO
                        $response = array(
                            'code' => '301',
                            'message' => $responseCodes[301],
                            'data' => '',
                            'status' => 'error'
                        );
                    }
                }else{
                    // RESPUESTA A ESPACIO EN BLANCO
                    $response = array(
                        'code' => '999',
                        'message' => $responseCodes[999],
                        'data' => '',
                        'status' => 'error'
                    );
                }
        } else {
            // RESPUESTA CONTRASEÑA INCORRECTA
            $response = array ('code' => '501',
            'message' => $responseCodes[501],
            'data' => '',
            'status' => 'error'
            );
        }
    }else{
        // USUARIO NO EXISTENTE
        $response = array(
            'code' => '500',
            'message' => $responseCodes[500],
            'data' => '',
            'status' => 'error'
        );
    }
    return $response;
}

    /**
    *    EXPOSICIÓN DEL SERVICIO (WSDL)
    **/
    // Exposición del servicio (WSDL) PHP v7.2 o superior
    @$server->service(file_get_contents("php://input"));