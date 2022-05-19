<?php
    
    require_once __DIR__.'/security/controlAcceso.php';

    $controlAcceso = new ControlAcceso();
    if($controlAcceso -> getUser() != null) {
        $controlAcceso -> logOut();
    }
    
    header('Location: /urban/');
    exit;
?>