<?php

    require_once __DIR__.'/../security/controlAccess.php';
    require_once __DIR__.'/../model/managers/LoginManager.php';
    include_once __DIR__.'/../helpers/validateData.php';

    $loginManager = new LoginManager();
    $controlAccess = new ControlAccess();
    
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = validateData($_POST['email']);
    $pass = validateData($_POST['password']);

    if($loginManager -> checkEmail($email) == 1) {
        //Comprobamos si la contraseña es correcta
        $passwordCheck = password_verify($pass, $loginManager -> getPassword($email));

        if($passwordCheck) {
            //si la contraseña es correcta
            $userInfo = $loginManager -> getUserInfo($email);

            //Guardo en la sesion un array con la info del 
            $controlAccess -> setUser($userInfo);

            if(isset($_POST['remember']) && $_POST['remember'] == 'yes') {
                $controlAccess -> setUserCredential($email, $pass);
            } else {
                $controlAccess -> deleteUserCredential();
            }

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