<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/GenderManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$genero = new GenderManager();

if($requestMethod == 'POST') {
    $nombre = '';

    if (isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if (isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = $_GET['id'];

        $resp = $genero -> update($id, $nombre);

        echo json_encode($resp);

    } else {
        $resp = $genero -> insert($nombre);

        echo json_encode($resp);
    }

} else if($requestMethod == 'DELETE') {

    $id = $_GET['id'];
    $resp = $genero -> delete($id);

    echo json_encode($resp);
}


?>