<?php

include_once __DIR__.'/../helpers/validateData.php';

function putPregReplace($cadena) {

    //Elimina los espacios en blanco de los saltos de linea
    $eliminar_espacios = preg_replace('/[\r\s]+/m', ' ', $cadena);

    //Elimina todo el webKit que trae hasta el name=" y lo mete en un array
    preg_match_all('/"[a-zA-Z]+"\s([0-9\w\s\<\>\?\¿\!\¡\#\=\&\€\$\%\:\*\+\(\)áéíóúäëïöüâêîôûàèìòùç\;@.ñ\,_\/]|)+/', $eliminar_espacios, $eliminar_webkit, PREG_PATTERN_ORDER);

    $datos_formulario = [];

    for ($i = 0; $i < count($eliminar_webkit[0]); $i++) {

        $string = $eliminar_webkit[0][$i];

        //elimina la segunda parte quedandose con el name del input
        $primera_parte = preg_replace('/"\s(.?)+$/', '', $string);
        //elimina las comillas
        $primera_parte = preg_replace('/"/', '', $primera_parte);
        //elimina la primera parte quedandose con el valor del input
        $segunda_parte = preg_replace('/"\w+"/', '', $string);

        $datos_formulario[$primera_parte] = validateData(trim($segunda_parte));
    }

    //array asociativo con los datos
    return $datos_formulario;
}
