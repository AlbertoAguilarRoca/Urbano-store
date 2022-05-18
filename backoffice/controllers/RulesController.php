<?php

require_once __DIR__.'/../security/controlAccess.php';
require_once __DIR__ .'/../model/managers/RulesManager.php';
include_once __DIR__.'/../helpers/validateData.php';
include_once __DIR__.'/../helpers/Referencia.php';


$requestMethod = $_SERVER['REQUEST_METHOD'];
$rulesManager = new RulesManager();

$id_regla = $nombre = $grupo = $fecha_inicio = $fecha_fin = $tipo_reduccion = $reduccion = $tasas_incluidas = $tipo = $valor_id = $valor_nombre = '';

if($requestMethod === 'POST') {

    $cond_extr = [];

    if(isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if(isset($_POST['grupo'])) {
        $grupo = validateData($_POST['grupo']);
    }

    if(isset($_POST['fecha_inicio'])) {
        $fecha_inicio = validateData($_POST['fecha_inicio']);
        $fecha_inicio = strtotime($fecha_inicio);
    }

    if(isset($_POST['fecha_fin'])) {
        $fecha_fin = validateData($_POST['fecha_fin']);
        $fecha_fin = strtotime($fecha_fin);
    }

    //Validamos que la fecha de fin sea mayor a la de inicio
    if($fecha_inicio >= $fecha_fin) {
        echo json_encode('Error: la fecha de fin debe ser mayor a la de inicio.');
        exit;
    } else {
        $fecha_inicio = date('Y-m-d H:i:s', $fecha_inicio);
        $fecha_fin = date('Y-m-d H:i:s', $fecha_fin);
    }

    if(isset($_POST['tipo_reduccion'])) {
        $tipo_reduccion = validateData($_POST['tipo_reduccion']);
    }

    if(isset($_POST['tasas_incluidas'])) {
        $tasas_incluidas = validateData($_POST['tasas_incluidas']);
    }

    if(isset($_POST['reduccion'])) {
        $reduccion = validateData($_POST['reduccion']);
    }

    //validacion de formato de la reduccion

    //Si el tipo de reduccion es fijo sera cualquier numero con un punto y dos decimales
    if($tipo_reduccion == 'cantidad-fija') {

        if(preg_match('/^\d+(\.\d{1,2})?$/', $reduccion) == 0) {
            echo json_encode('Error: la reducción contiene errores de formato. Solo será permitido el punto como separador y dos decimales.');
            exit;
        }

        //correccion si el formato lleva un 0 y otros numeros delaten Ej: 015.50
        $formato = explode('.', $reduccion);
        if(strlen($formato[0]) > 1) {
            $formato[0] = ltrim($formato[0], "0");
        }

        $reduccion = $formato[0].'.'.$formato[1];
    }

    //Si el tipo de reduccion es porcentaje sera numero entre 0 y 1 con un punto y dos decimales. si es 1 solo sera permitido 1, 1.0, 1.00
    if($tipo_reduccion == 'porcentaje') {

        if(preg_match('/^(0\.\d{1,2}|1(\.0{1,2})?)$/', $reduccion) == 0) {
            echo json_encode('Error: la reducción contiene errores de formato. La reducción en porcentaje irá de 0 a 1, y solo podrás incluir dos decimales.');
            exit;
        }

    }

    if(isset($_POST['condiciones'])) {
        $cond = json_decode($_POST['condiciones'], true);
        for ($i=0; $i < count($cond); $i++) { 
            $cond_extr[$i]['tipo'] = $cond[$i]['tipo'];
            $cond_extr[$i]['id'] = $cond[$i]['id'];
            $cond_extr[$i]['valor'] = $cond[$i]['valor'];
        }
    }

    if(isset($_POST['_method']) && $_POST['_method'] == 'put') {

        $id_regla = $_GET['id_regla'];

        //update
        $resp = $rulesManager -> update($id_regla, $nombre, $grupo, $fecha_inicio, $fecha_fin, $tipo_reduccion, $reduccion, $tasas_incluidas);

        //borro todas las condiciones
        $del_cond = $rulesManager -> delete_cond($id_regla);

        if($resp == TRUE && $del_cond == TRUE) {
            for ($i=0; $i < count($cond_extr); $i++) { 
                $resp = $rulesManager -> insert_conditions($id_regla, $cond_extr[$i]['tipo'], $cond_extr[$i]['id'], $cond_extr[$i]['valor']);
            }
        }

        echo json_encode($resp);

    } else {

        //creamos el id de la regla comercial
        $ref = new Referencia(15);
        $id_regla = $ref -> getRef();

        $checkId = intval($rulesManager -> checkIfIdRuleExist($id_regla));
        //comprueba si ese id ya existe
        while ($checkId != 0) {
            $newRef = new Referencia(15);
            $id_regla = $newRef -> getRef();
            $checkId = intval($rulesManager -> checkIfIdRuleExist($id_regla));
        }

        $resp = $rulesManager -> insert_rule($id_regla, $nombre, $grupo, $fecha_inicio, $fecha_fin, $tipo_reduccion, $reduccion, $tasas_incluidas);

        //Si la regla comercial se creo correctamente, procedo a incluir las condiciones
        if($resp == TRUE) {
            for ($i=0; $i < count($cond_extr); $i++) { 
                $resp = $rulesManager -> insert_conditions($id_regla, $cond_extr[$i]['tipo'], $cond_extr[$i]['id'], $cond_extr[$i]['valor']);
            }
        }

        echo json_encode($resp);
    }

    
} else if($requestMethod == 'DELETE') {
    $id_regla = $_GET['id_regla'];
    
    $resp = $rulesManager -> delete_cond($id_regla);
    $resp = $rulesManager -> delete($id_regla);

    echo json_encode($resp);
}

?>