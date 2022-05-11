<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/CategoryManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$categoryManager = new CategoryManager();

$id = $nombre = $descripcion = $estado = '';

if ($requestMethod == 'POST') {

    if (isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if (isset($_POST['descripcion'])) {
        $descripcion = validateData($_POST['descripcion']);
    }

    if (isset($_POST['estado'])) {
        $estado = 1;
    } else {
        $estado = 0;
    }

    if (isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = '';

        if (isset($_GET['id'])) {
            $id = validateData($_GET['id']);
        }

        //Si el usuario inactiva la categoria, inactivo todas las subcategorias de dicha categoria
        if($estado == 0) {
            $categoryManager -> inactiveAllSubcategories($id);
            $categoryManager -> inactiveAllProductsFromSybcategories();
        }

        $resp = $categoryManager->update($nombre, $estado, $descripcion, $id);
        echo json_encode($resp);

    } else {
        $resp = $categoryManager->insert($nombre, $estado, $descripcion);
        echo json_encode($resp);
    }
} else if ($requestMethod == 'DELETE') {

    $id = '';
    if (isset($_GET['id'])) {
        $id = validateData($_GET['id']);
        $resp = $categoryManager->delete($id);
        echo json_encode($resp);
    }
} else if($requestMethod == 'GET') {
    $resp = $categoryManager->getCategories();
    echo json_encode($resp);
}

?>