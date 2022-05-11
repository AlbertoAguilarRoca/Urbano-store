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

?>