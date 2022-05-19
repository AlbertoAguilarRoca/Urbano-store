<?php 

require_once __DIR__.'/../../security/controlAcceso.php';
$controlAcceso = new ControlAcceso();

require_once __DIR__.'/../model/managers/ClientManager.php';
include_once __DIR__.'/../helpers/validateData.php';


$clientManager = new ClientManager();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = validateData($_POST['email']);
    $pass = validateData($_POST['password']);

    if($clientManager -> checkEmail($email) == '1') {
        //Comprobamos si la contraseña es correcta
        $passwordCheck = password_verify($pass, $clientManager -> getPassword($email));

        if($passwordCheck) {
            //si la contraseña es correcta
            $clientInfo = $clientManager -> getClientId($email);

            //Guardo en la sesion un array con la info del 
            $controlAcceso -> setUser($clientInfo);

            echo json_encode(true);

        } else {
            //password incorrecta
            echo json_encode("La contraseña no es correcta");
        }
    } else {
        echo json_encode("El email no es correcto");
    }

}

?>