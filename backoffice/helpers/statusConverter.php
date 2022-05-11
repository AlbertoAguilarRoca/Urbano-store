<?php

    function convertirEstado($bool) {
        if($bool == 1) {
            return 'Activo';
        } else if($bool == 0) {
            return 'Inactivo';
        } else {
            return 'Activo';
        }
    }

    function convertirEstado2($bool) {
        if($bool == 1) {
            return 'Si';
        } else if($bool == 0) {
            return 'No';
        } else {
            return 'Si';
        }
    }

?>