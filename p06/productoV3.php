<?php
    // IMPORTACION DE LIBRERIA
    include 'firebaseCRUD.php';

	//header("Content-Type: text/xml; charset=UTF-8\r\n");
    ini_set("log_errors", 1);
    ini_set("error_log", "reportes/php-error-producto.log");

    require_once 'vendor/autoload.php';
    //require_once 'nusoap/lib/nusoap.php';     //PHP v7.4.x o inferior
    
    $server = new soap_server();
    /*
        configureWSDL('Nombre del Servicio', 'targetNamespace');
        
        targetNamespace: Hacemos que el esquema que estamos creando tenga asociado un espacio 
                         de nombres propio (target namespace). Para ello se puede utilizar el 
                         atributo targetNamespace del elemento “schema”:
    */
    $server->configureWSDL('WebServicesBUAP', 'urn:buap_api');
 	$server->soap_defencoding = 'UTF-8';
	$server->decode_utf8 = false;
	$server->encode_utf8 = true;

    $server->wsdl->addComplexType(
        'RespuestaGetProd',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'code'          => ['name' => 'code',          'type' => 'xsd:string'],
            'message'       => ['name' => 'message',       'type' => 'xsd:string'],
            'data'          => ['name' => 'data',          'type' => 'xsd:string'],
            'status'        => ['name' => 'status',        'type' => 'xsd:string']
        )
    );

    $server->wsdl->addComplexType(
        'RespuestaGetDetails',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'code'          => ['name' => 'code',          'type' => 'xsd:string'],
            'message'       => ['name' => 'message',       'type' => 'xsd:string'],
            'data'          => ['name' => 'data',          'type' => 'xsd:string'],
            'status'        => ['name' => 'status',        'type' => 'xsd:string'],
            'oferta'        => ['name' => 'oferta',        'type' => 'xsd:boolean']
        )
    );

    $server->register( 'getProd',                               // Nombre de la operación (método)
                        array('user' => 'xsd:string',
                              'pass' => 'xsd:string',    
                              'categoria' => 'xsd:string'),     // Lista de parámetros; varios de tipo simple o un tipo complejo
                        array('return' => 'tns:RespuestaGetProd'), // Respuesta; de tipo simple o de tipo complejo
                        'urn:producto',                         // Namespace para entradas (input) y salidas (output)
                        'urn:producto#getProd',                 // Nombre de la acción (soapAction)
                        'rpc',                                  // Estilo de comunicación (rpc|document)
                        'encoded',                              // Tipo de uso (encoded|literal)
                        'Nos da una lista de productos de cada categoría.'  // Documentación o descripción del método
                     );

    $server->register( 'getDetails',                            // Nombre de la operación (método)
                        array('user' => 'xsd:string',
                              'pass' => 'xsd:string',
                              'isbn' => 'xsd:string'),     // Lista de parámetros; varios de tipo simple o un tipo complejo
                        array('return' => 'tns:RespuestaGetDetails'), // Respuesta; de tipo simple o de tipo complejo
                        'urn:producto',                         // Namespace para entradas (input) y salidas (output)
                        'urn:producto#getDetails',              // Nombre de la acción (soapAction)
                        'rpc',                                  // Estilo de comunicación (rpc|document)
                        'encoded',                              // Tipo de uso (encoded|literal)
                        'Nos da una lista de detalles de cada producto.'  // Documentación o descripción del método
                     );

    function getProd($user, $pass, $categoria) {
        $categoria = strtolower($categoria);


        if ( read_document('usuarios', $user) != NULL ) {
            if ( read_document('usuarios', $user) === md5($pass) ) {
                if ( read_document( 'productos',$categoria ) ) {
                    $resp = json_encode( read_document( 'productos', $categoria ), JSON_PRETTY_PRINT );

                }
                else {
                    $resp = json_encode( read_document( 'repuestas', '300' ), JSON_PRETTY_PRINT );

                }
            }
            else {
                $resp = json_encode( read_document( 'repuestas', '501' ), JSON_PRETTY_PRINT );

            }
        }
        else {
            $resp = json_encode( read_document( 'repuestas', '500' ), JSON_PRETTY_PRINT );

        }
        
        return $resp;
    }

    /**function getDetails($user, $pass, $isbn) {
        global $detalles, $respuestas, $usuarios;

        $resp = array(
            'code'    => 999,
            'message' => $respuestas[999],
            'data'    => '',
            'status'  => 'error',
            'oferta'  => false
        );

        if ( array_key_exists($user, $usuarios) ) {
            if ( $usuarios[$user] === md5($pass) ) {
                if ( array_key_exists($isbn, $detalles) ) {
                    $resp['code'] = 201;
                    $resp['message'] = $respuestas[201];
                    $resp['status'] = 'success';
                    $resp['data'] = json_encode($detalles[$isbn], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $resp['oferta'] = $detalles[$isbn]['Oferta'];
                }
                else {
                    $resp['code'] = 301;
                    $resp['message'] = $respuestas[301];
                }
            }
            else {
                $resp['code'] = 501;
                $resp['message'] = $respuestas[501];
            }
        }
        else {
            $resp['code'] = 500;
            $resp['message'] = $respuestas[500];
        }

        return $resp;
    }**/
  
    // Exposición del servicio (WSDL)
    //$data = !empty($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA:'';
    //@$server->service($data);

    // Exposición del servicio (WSDL) PHP v7.2 o superior
    @$server->service( file_get_contents("php://input") );
?>