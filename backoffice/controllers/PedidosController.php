<?php

require_once __DIR__.'/../security/controlAccess.php';
require_once __DIR__ .'/../model/managers/PedidoManager.php';
include_once __DIR__.'/../helpers/validateData.php';

    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $pedidosManager = new PedidoManager();

    if($requestMethod == 'POST') {

        $ref_pedido = $_GET['id_pedido'];
        $estado = $_POST['estado'];

        $resp = $pedidosManager -> updateEstado($estado, $ref_pedido);
        echo json_encode($resp);
    }


?>