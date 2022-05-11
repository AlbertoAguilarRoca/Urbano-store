<?php
    
    require_once __DIR__.'/security/controlAccess.php';

    $controlAccess = new ControlAccess();
    if($controlAccess -> getUser() != null) {
        $controlAccess -> logOut();
    }
    
    header('Location: /urban/backoffice/login.php');
    exit;
?>