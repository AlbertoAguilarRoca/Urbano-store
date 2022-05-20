<?php

require_once __DIR__.'/../../security/controlAcceso.php';
$controlAcceso = new ControlAcceso();

require_once __DIR__ . '/../model/managers/ClientManager.php';
include_once __DIR__ . '/../helpers/validateData.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$clientmanager = new ClientManager();

$nombre = $apellido1 = $apellido2 = $email = $passToSesion = $pass = $fecha_nacimiento = $subscrito = $invitado = $registrado = $ultima_visita = $genero = '';

if($requestMethod == 'POST') {

    if (isset($_POST['nombre'])) {
        $nombre = validateData($_POST['nombre']);
    }

    if (isset($_POST['apellido1'])) {
        $apellido1 = validateData($_POST['apellido1']);
    }

    if (isset($_POST['apellido2'])) {
        $apellido2 = validateData($_POST['apellido2']);
    }

    if (isset($_POST['email'])) {
        $email = validateData($_POST['email']);
    }

    if (isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['year'])) {
        $fecha = strtotime($_POST['dia']."-".$_POST['mes']."-".$_POST['year']);
        $fecha_nacimiento = date("Y-m-d", $fecha);
    }

    if (isset($_POST['newsletter'])) {
        $subscrito = 1;
    } else {
        $subscrito = 0;
    }

    if (isset($_POST['invitado'])) {
        $invitado = 1;
    } else {
        $invitado = 0;

        //Si no es invitado, guardo la password
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $pass = validateData($_POST['password']);
            $passToSesion = $pass;
            $pass = password_hash($pass, PASSWORD_DEFAULT);
        }
    }

    $registrado = date('Y-m-d h:i:s');
    $ultima_visita = $registrado;

    if (isset($_POST['genero'])) {
        $genero = $_POST['genero'];
    }

   
    $resp = $clientmanager -> insert($nombre, $apellido1, $apellido2, $email, $pass, $fecha_nacimiento, $subscrito, $invitado, $registrado, $ultima_visita, $genero);

    if($resp == TRUE) {
        $clientInfo = [ 'email' => $email, 'password' => $passToSesion ];
        //Guardo en la sesion un array con la info del 
        $controlAcceso -> setUser($clientInfo);
    }

    echo json_encode($resp);
    

}

?>