
<?php

    //clase para generar codigos de referencia, ya sea para la base de datos, codigos promocionales, o cualquier otra cosa.

    class Referencia {
        private $referencia;

        private $CHARS = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        function __construct($longitud) {
            $this -> referencia = substr(str_shuffle($this -> CHARS), 0, $longitud);
        }

        function getRef() {
            return $this -> referencia;
        }
    }

?>