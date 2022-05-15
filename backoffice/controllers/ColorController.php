<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/ColorManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$color = new ColorManager();
$codigo = $nombre = '';

if($requestMethod == 'POST') {

    if (isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if (isset($_POST['codigo_hex'])) {
        $codigo = validateData($_POST['codigo_hex']);
    }

    if (isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = $_GET['id'];

        $resp = $color -> update($codigo, $id, $nombre);

        echo json_encode($resp);

    } else {
        $resp = $color -> insert($codigo, $nombre);

        echo json_encode($resp);
    }

} else if($requestMethod == 'DELETE') {

    $id = $_GET['id'];
    $resp = $color -> delete($id);

    echo json_encode($resp);
}


?>