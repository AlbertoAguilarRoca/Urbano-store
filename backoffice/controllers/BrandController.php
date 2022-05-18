<?php

require_once __DIR__.'/../security/controlAccess.php';
require_once __DIR__ .'/../model/managers/BrandManager.php';
include_once __DIR__.'/../helpers/validateData.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $brandManager = new BrandManager();

    if($requestMethod == 'POST') {

        $nombre = $desc = $proveedor = $estado = '';

        if(isset($_POST['nombre'])) {
            $nombre = validateData($_POST['nombre']);
        }

        if(isset($_POST['descripcion'])) {
            $desc = validateData($_POST['descripcion']);
        }

        if(isset($_POST['proveedor'])) {
            $proveedor = validateData($_POST['proveedor']);
        }

        if(isset($_POST['estado']) && $_POST['estado'] == 'yes') {
            $estado = 1;
        } else {
            $estado = 0;
        }
        
        if(isset($_POST['_method']) && $_POST['_method'] == 'put') {
            
            $id = '';
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            // ACTUALIZA el contenido a la bd
            $resp = $brandManager -> update($id, $nombre, $estado, $desc, $proveedor);
            echo json_encode($resp);
        } else {
            //Subimos el contenido a la bd
            $resp = $brandManager -> insert($nombre, $estado, $desc, $proveedor);
            echo json_encode($resp);
        }

    } else if($requestMethod == 'DELETE') {

        if(isset($_GET['id'])) {
            $id = validateData($_GET['id']);
            $resp = $brandManager -> delete($id);
            echo json_encode($resp);
        } else {
            echo json_encode('Id no encontrado.');
        }

    }

?>