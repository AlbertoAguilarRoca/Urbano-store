<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/SizeManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$size = new SizeManager();

if($requestMethod == 'POST') {
    $talla = '';

    if (isset($_POST['talla'])) {
        $talla = validateData($_POST['talla']);
    }

    if (isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = $_GET['id'];

        $resp = $size -> update($id, $talla);

        echo json_encode($resp);

    } else {
        $resp = $size -> insert($talla);

        echo json_encode($resp);
    }

} else if($requestMethod == 'DELETE') {

    $id = $_GET['id'];
    $resp = $size -> delete($id);

    echo json_encode($resp);
}


?>