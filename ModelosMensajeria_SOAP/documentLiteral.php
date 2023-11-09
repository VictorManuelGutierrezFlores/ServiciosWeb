<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document/Literal</title>
</head>

<body>
	<?php
	/**
		IMPORTANTE:	

		Si el estilo de comunicación es "document" y tipo de uso "literal", entonces
			Parámetros = arreglo de datos
			Respuesta  = objeto con atributos, contenido en otro objeto

		Si el estilo de comunicación es "rpc", y tipo de uso "literal" o "encoded", entonces
			Parámetros = variables independientes
			Respuesta  = objeto con atributos
	 **/
	// WSDL del servicio
	$servicio = 'http://localhost:51546/wcfPersonas.svc?wsdl';

	// Parámetros independientes
	$id = "1" ;
	// Arreglo de parámetros
	$parametros = array('identification' => $id);

	echo '<h2>Parámetros de entrada</h2>';
	print_r($parametros);

	// Se crea el cliente del servicio
	$client = new SoapClient($servicio, $parametros);

	// Se invoca el metodo que vamos a probar
	$result = $client->ObtenerPersona($parametros);

	echo '<h2>Valor "dump" de la respuesta</h2>';
	var_dump($result);

	echo '<h2>Valor "echo" de la respuesta</h2>';
	if (!isset($result->ObtenerPersonaResult->Error)) {
		echo 'Mensaje: ' . $result->ObtenerPersonaResult->Mensaje . '<br>';
		echo 'Nombre: ' . $result->ObtenerPersonaResult->Nombre . '<br>';
		echo 'Edad: ' . $result->ObtenerPersonaResult->Edad . '<br>';
	} else {
		echo 'Error: ' . $result->ObtenerPersonaResult->Error . '<br>';
	}
	/**
	 **	Este código es compatible con PHP v5 o superior
	 **/
	?>
</body>

</html>