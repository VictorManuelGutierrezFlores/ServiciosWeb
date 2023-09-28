<?php

function create_document($project, $collection, $document) {
    $url = 'https://'.$project.'.firebaseio.com/'.$collection.'.json';

    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                // CONEXION MEDIANTE URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     // ACEPTACION DE DEVOLUCION
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
$coleccion = 'productos';

$data = '{
    "libros": {
        "LIB001": "Libro 1",
        "LIB002": "Libro 2",
        "LIB003": "Libro 3"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "comics": {
        "COM001": "Comic 1",
        "COM002": "Comic 2",
        "COM003": "Comic 3"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "mangas": {
        "MAN001": "Manga 1",
        "MAN002": "Manga 2",
        "MAN003": "Manga 3"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "articulos": {
        "ART001": "Articulo 1",
        "ART002": "Articulo 2",
        "ART003": "Articulo 3"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}
?>