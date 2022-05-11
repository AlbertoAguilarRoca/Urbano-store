<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/SubCategoryManager.php';
require_once __DIR__ . '/../model/managers/CategoryManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$subCategoryManager = new SubCategoryManager();
$categoryManager = new CategoryManager();

$id = $nombre = $descripcion = $estado = $id_categoria = '';

if ($requestMethod == 'POST') {

    if (isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if (isset($_POST['descripcion'])) {
        $descripcion = validateData($_POST['descripcion']);
    }
    
    if (isset($_POST['id_categoria'])) {
        $id_categoria = validateData($_POST['id_categoria']);
    }
    if (isset($_POST['estado'])) {
        //Si el estado de la categoria es inactivo, la subcategoria se creará inactiva
        if($categoryManager -> checkCategoryStatus($id_categoria) == 1) {
            $estado = 1;
        } else {
            $estado = 0;    
        }

    } else {
        $estado = 0;
    }

    if (isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = '';

        if (isset($_GET['id'])) {
            $id = validateData($_GET['id']);
        }

        //Si el usuario inactiva la subcategoria, inactivo todas las productos de dicha subcategoria
        if($estado == 0) {
            $subCategoryManager -> inactiveAllProducts($id);
        }

        $resp = $subCategoryManager->update($nombre, $estado, $descripcion, $id_categoria, $id);
        echo json_encode($resp);

    } else {
        $resp = $subCategoryManager->insert($nombre, $estado, $descripcion, $id_categoria);
        echo json_encode($resp);
    }
} else if ($requestMethod == 'DELETE') {

    $id = '';
    if (isset($_GET['id'])) {
        $id = validateData($_GET['id']);
        $resp = $subCategoryManager->delete($id);
        echo json_encode($resp);
    }
} else if($requestMethod == 'GET') {
    $resp = $subCategoryManager->getSubcategories();
    echo json_encode($resp);
}

?>