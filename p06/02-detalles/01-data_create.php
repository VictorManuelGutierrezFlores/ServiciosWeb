<?php

function create_document($project, $collection, $document) {
    $url = 'https://'.$project.'.firebaseio.com/'.$collection.'.json';

    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

    // Se convierte a Object o NULL
    return json_decode($response);
}

$proyecto = 'productsws-f1161-default-rtdb';
$coleccion = 'detalles';

$data = '{
    "LIB001": {
        "Autor": "Autor X",
        "Nombre": "Libro 1",
        "Editorial": "Editorial X",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "LIB002": {
        "Autor": "Autor X",
        "Nombre": "Libro 2",
        "Editorial": "Editorial Y",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "LIB003": {
        "Autor": "Autor X",
        "Nombre": "Libro 3",
        "Editorial": "Editorial Z",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM001": {
        "Autor": "Autor X",
        "Nombre": "Comic 1",
        "Editorial": "Editorial X",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM002": {
        "Autor": "Autor X",
        "Nombre": "Comic 2",
        "Editorial": "Editorial Y",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM003": {
        "Autor": "Autor X",
        "Nombre": "Comic 3",
        "Editorial": "Editorial Z",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN001": {
        "Autor": "Autor X",
        "Nombre": "Manga 1",
        "Editorial": "Editorial X",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN002": {
        "Autor": "Autor X",
        "Nombre": "Manga 2",
        "Editorial": "Editorial Y",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN003": {
        "Autor": "Autor X",
        "Nombre": "Manga 3",
        "Editorial": "Editorial Z",
        "Fecha": 2020,
        "Precio": 1.0,
        "Descuento": 0.0
      }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN004": {
        "Autor": "Autor X",
        "Nombre": "Manga 3",
        "Editorial": "Editorial Q",
        "Fecha": 2021,
        "Precio": 1.0,
        "Descuento": 0.0
      }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}
?>