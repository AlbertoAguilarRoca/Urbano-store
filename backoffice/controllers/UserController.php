<?php

require_once __DIR__.'/../security/controlAccess.php';
require_once __DIR__ .'/../model/managers/LoginManager.php';
include_once __DIR__.'/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$loginManager = new LoginManager();

//inicializacion de variables 
$nombre = $apellidos = $email = $permiso = $password = $puesto = $typeFile = $binaryImage = '';

if($requestMethod == 'POST') {

    if(isset($_FILES['userFoto']['name'])) {
        $typeFile = $_FILES['userFoto']['type'];
        $nameFile = $_FILES['userFoto']['name'];
        $sizeFile = $_FILES['userFoto']['size'];
        //Aqui se almacena temporalmente los archivos subidos del servidor
        $imageUpload = fopen($_FILES['userFoto']['tmp_name'], 'r');
        $binaryImage = fread($imageUpload, $sizeFile);
        //Limpiamos los binarios para proceder con la subida
        $binaryImage = mysqli_escape_string($loginManager->getConnection(), $binaryImage);
    }

    if(isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }
    if(isset($_POST['apellidos'])) {
        $apellidos = validateData($_POST['apellidos']);
    }
    if(isset($_POST['email'])) {
        $email = validateData($_POST['email']);
    }
    if(isset($_POST['permiso'])) {
        $permiso = validateData($_POST['permiso']);
    }
    if(isset($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    if(isset($_POST['puesto'])) {
        $puesto = validateData($_POST['puesto']);
    }

    //Las fotos no se pueden enviar por PUT, entonces, si la petición post trae un input type hidden con name _method y el value put, entonces hará un update en vez de un insert
    if(isset($_POST['_method']) && $_POST['_method'] == 'put') {
        $id = '';

        if(isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $resp = $loginManager -> update($nombre, $apellidos, $email, $permiso, $password, $puesto, $binaryImage, $typeFile, $id);

        echo json_encode($resp);
    }else {
        $resp = $loginManager -> insert($nombre, $apellidos, $email, $permiso, $password, $puesto, $binaryImage, $typeFile);
    
        echo json_encode($resp);
    }
    
} else if ($requestMethod == 'DELETE') {
    $id = '';

        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $resp = $loginManager -> delete($id);

            echo json_encode($resp);
        }
}


?>