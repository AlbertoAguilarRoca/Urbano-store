<?php 
    include_once __DIR__ . './security/ControlAcceso.php';
    $control = new ControlAcceso();

    require_once __DIR__ . '/./head.php'; 
?>


<?php 

    if(isset($_SESSION['cliente']['id_cliente'])) {
        echo 'Id del usuario: '.$_SESSION['cliente']['id_cliente'];
    }

?>
<br>
<br>
<button><a href="http://localhost/urban/logout.php">Cerrar sesión</a></button>


<?php require_once __DIR__ . '/./footer.php'; ?>
