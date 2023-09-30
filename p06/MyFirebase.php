<?php

    class MyFirebase{
        private $project;

        public function __construct( $project = ''){
            $this->project = $project;
        }

        private function runCurl($collection, $document){
            
            $url = 'https://'.$this->project.'.firebaseio.com/'.$collection.'/'.$document.'.json';
        
            $ch =  curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
            $response = curl_exec($ch);
        
            curl_close($ch);
        
            // Se convierte a Object o NULL
            return $response;
        }

        // METODO DE OBTENCION DE PRODUCTOS
        public function obtainProducts($category){
            $res = $this->runCurl( 'productos', $category);
            $res = json_decode($res);

            if(!is_null($res)) {
                return json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return null;
            }
        }
        // METODO VERIFICADOR DE USURIO
        // RETORNA BOOLEANO
        public function isUserInDB($name){
            $response = $this->runCurl('usuarios', $name);
            $response = json_decode($response);

            if( !is_null($response) ) {
                // Existe
                return true;
            } else {
                // No existe
                return false;
            }

        }
        // Metodo de extraccion de contraseña
        public function obtainPassword( $user ){
            $response = $this->runCurl('usuarios', $user);
            $response = json_decode($response);

            if(!is_null($response)) {
                // Existe
                //return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return $response;
            } else {
                // No existe
                return null;
            }
        }

        // METODO VERIFICADOR DE CATEGORIAS
        // RETORNA BOOLEANO
        public function isCategoryInDB($name){
            $response = $this->runCurl('productos', $name);
            $response = json_decode($response);

            if(!is_null($response) || isset($response['name'])) {
                // Existe¿
                return true;
            } else {
                // No existe
                return false;
            }
        }
        // METODO VERIFICADOR DE ISBN
        // DEVUELVE BOOLEANO
        public function isIsbnInDB($key){
            $response = $this->runCurl('detalles', $key);
            $response = json_decode($response);

            if(!is_null($response)) {
                // Existe¿
                return true;
            } else {
                // No existe
                return false;
            }
        }
        // METODO QUE OBTIENE LA COLECCION DETALLES
        // DEVUELVE LA COLECCION EN JSON
        public function obtainDatails( $isbn ){
            $response = $this->runCurl( 'detalles', $isbn);
            $response = json_decode($response);

            if(!is_null($response)) {
                    return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return null;
            }
        }
        // METODO QUE OBTIENE HTTP CODES
        public function obtainMessages( $code ){
            $response = $this->runCurl( 'respuestas', $code);
            $response = json_decode($response);

            if(!is_null($response)) {
                return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return null;
            }
        }

    }
