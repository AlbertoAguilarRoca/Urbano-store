<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/DireccionManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$direccionManager = new DireccionManager();

$id_cliente = $nif = $razon_social = $es_empresa = $direccion1 = $direccion2 = $codigo_postal = $provincia = $localidad = $telefono = $guardada = '';

if($requestMethod == 'POST') {

    if(isset($_GET['cliente'])) {
        $id_cliente = $_GET['cliente'];
    }


    if(isset($_POST['empresa'])) {
        $es_empresa = 1;
        $nif = validateData($_POST['nif']);
        $razon_social = validateData($_POST['razon-social']);
    } else {
        $es_empresa = 0;
    }

    if(isset($_POST['direccion'])) {
        $direccion1 = validateData($_POST['direccion']);
    }

    if(isset($_POST['direccion2'])) {
        $direccion2 = validateData($_POST['direccion2']);
    }

    if(isset($_POST['codigo-postal'])) {
        $codigo_postal = validateData($_POST['codigo-postal']);
    }

    if(isset($_POST['provincia'])) {
        $provincia = $_POST['provincia'];
    }

    if(isset($_POST['localidad'])) {
        $localidad = $_POST['localidad'];
    }

    if(isset($_POST['telefono'])) {
        $telefono = validateData($_POST['telefono']);
    }

    if(isset($_POST['guardada'])) {
        $guardada = 1;
    } else {
        $guardada = 0;
    }


    $resp = $direccionManager -> insert($id_cliente, $nif, $razon_social, $es_empresa, $direccion1, $direccion2, $codigo_postal, $provincia, $localidad, $telefono, $guardada);

    echo json_encode($resp);


}










?>