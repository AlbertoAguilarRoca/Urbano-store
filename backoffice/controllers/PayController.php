<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/DireccionManager.php';
require_once __DIR__ . '/../model/managers/ClientManager.php';
require_once __DIR__ . '/../model/managers/PedidoManager.php';
include_once __DIR__ . '/../helpers/validateData.php';
include_once __DIR__ . '/../helpers/Referencia.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

$direccionManager = new DireccionManager();
$clientManager = new clientManager();
$pedidoManager = new PedidoManager();

//inicializacion de direccion y cliente
$id_cliente = $id_direccion = $id_direccion_fac = $nif = $razon_social = $es_empresa = $direccion1 = $direccion2 = $codigo_postal = $provincia = $localidad = $telefono = $nombre = $apellido1 = $apellido2 = $email = $dir_facturacion = $direccion_fac = $direccion2_fac = $codigo_postal_fac = $provincia_fac = $localidad_fac = $telefono_fac = '';

$productos = [];
$prueba = 'Todo mal';
/**
 * CASO DE QUE EL CLIENTE ESTE REGISTRADO
 * - Recibo el id del cliente por la sesion
 * - Compruebo si la direccion de envio esta ya guardada o no
 * - Si esta guardada y no especifica la direccion de facturacion y
 * el cliente esta registrado, subo el pedido y los productos de este
 * - Si la direccion de envio esta guardada pero especifico otra direccion de facturacion, guardo la direccion de factura al cliente como no guardada y subo el pedido
 * 
 * Si el cliente no esta registrado:
 * Creo el cliente como invitado
 * Creo la direccion de envio,
 * Creo la direccion de facturacion si es diferente
 * Creo el pedido
 * Meto los productos en el pedido
 * 
 * 
 */
if($requestMethod == 'POST') {

    if(isset($_POST['direccion-guardada']) && $_POST['direccion-guardada'] != 'no') {
        //cliente usa direccion guardada
        $id_direccion = $_POST['direccion-guardada'];
    } else {
        //Tengo que guardar la direccion
        if(isset($_POST['direccion'])) {
            $direccion1 = validateData($_POST['direccion']);
        }

        if(isset($_POST['direccion2'])) {
            $direccion2 = validateData($_POST['direccion2']);
        }

        if(isset($_POST['codigo-postal'])) {
            $codigo_postal = validateData($_POST['codigo-postal']);
        }

        if(isset($_POST['provincia'])) {
            $provincia = validateData($_POST['provincia']);
        }

        if(isset($_POST['municipio'])) {
            $localidad = validateData($_POST['municipio']);
        }

        if(isset($_POST['telefono'])) {
            $telefono = validateData($_POST['telefono']);
        }
    }

    if(isset($_POST['dir_facturacion'])) {
        //direccion de envio y facturacion es la misma
        $id_direccion_fac = $id_direccion;
    } else {
        if(isset($_POST['es_empresa'])) {
            $es_empresa = 1;
            $nif = validateData($_POST['nif']);
            $razon_social = validateData($_POST['razon-social']);
        } else {
            $es_empresa = 0;
        }

        if(isset($_POST['direccion_fac'])) {
            $direccion_fac = validateData($_POST['direccion_fac']);
        }

        if(isset($_POST['direccion2_fac'])) {
            $direccion2_fac = validateData($_POST['direccion2_fac']);
        }

        if(isset($_POST['codigo-postal_fac'])) {
            $codigo_postal_fac = validateData($_POST['codigo-postal_fac']);
        }

        if(isset($_POST['provincia_fac'])) {
            $provincia_fac = validateData($_POST['provincia_fac']);
        }

        if(isset($_POST['municipio_fac'])) {
            $localidad_fac = validateData($_POST['municipio_fac']);
        }

        if(isset($_POST['telefono_fac'])) {
            $telefono_fac = validateData($_POST['telefono_fac']);
        }
    }



    if(isset($_POST['cliente_id']) && $_POST['cliente_id'] != '') {
        //El cliente ya esta registrado
        $id_cliente = $_POST['cliente_id'];

        //Si la direccion de facturacion es diferente, la inserto
        if(!isset($_POST['dir_facturacion'])) {
            $resp = $direccionManager -> insert($id_cliente, $nif, $razon_social, $es_empresa, $direccion_fac, $direccion2_fac, $codigo_postal_fac, $provincia_fac, $localidad_fac, $telefono_fac, 0);

            $id_direccion_fac = $direccionManager -> getIdByDireccion($direccion_fac);
            $prueba = 'Todo deberia haber ido bien';
            if($resp != TRUE) {
                echo json_encode($resp);
                exit;
            }
        }

    } else {
        if(isset($_POST['nombre'])) {
            $nombre = validateData($_POST['nombre']);
        }

        if(isset($_POST['apellido1'])) {
            $apellido1 = validateData($_POST['apellido1']);
        }

        if(isset($_POST['apellido2'])) {
            $apellido2 = validateData($_POST['apellido2']);
        }

        if(isset($_POST['email'])) {
            $email = validateData($_POST['email']);
        }

        $registrado = date('Y-m-d h:i:s');
        $ultima_vis = $registrado;
        //registro el cliente
        $resp = $clientManager -> insert($nombre, $apellido1, $apellido2, $email, '', '', 0, 1, $registrado, $ultima_vis, 'O');
        $prueba = 'intento registrar';
        if($resp != TRUE) {
            echo json_encode($resp);
            exit;
        }

        //cojo el id del cliente
        $id_cliente = $clientManager -> getClientId($email);

        //inserto la direccion
        $resp = $direccionManager -> insert($id_cliente, '', '', 0, $direccion1, $direccion2, $codigo_postal, $provincia, $localidad, $telefono, 0);

        if($resp != TRUE) {
            echo json_encode($resp);
            exit;
        }

        $id_direccion = $direccionManager -> getIdByDireccion($direccion1);
        //si hay otra direccion de facturacion, la inserto
        if(isset($_POST['dir_facturacion'])) {
            //ambas direciones son la misma, busco el id de la que acabo de subir y la incluyo
            $id_direccion_fac = $id_direccion;
        } else {
            //inserto la direccion
            $resp = $direccionManager -> insert($id_cliente, $nif, $razon_social, $es_empresa, $direccion_fac, $direccion2_fac, $codigo_postal_fac, $provincia_fac, $localidad_fac, $telefono_fac, 0);

            $id_direccion_fac = $direccionManager -> getIdByDireccion($direccion_fac);
        }

        if($resp != TRUE) {
            echo json_encode($resp);
            exit;
        } 
    }


    //Una vez que tengo los datos del cliente y las direcciones creo el pedido
    $ref = new Referencia(15);
    $ref_pedido = $ref -> getRef();
    $importe = $_POST['importe'];

    $resp = $pedidoManager -> insert($ref_pedido, $id_cliente, $importe, 1, 'Paypal', 'no-code', $id_direccion, $id_direccion_fac);

    if($resp != TRUE) {
        echo json_encode($resp);
        exit;
    } 


    $id_pedido = $pedidoManager -> getIdPedidoByRef($ref_pedido);

    //inserto los productos del pedido
    $productos = json_decode($_POST['productos'], true);

    for ($i=0; $i < count($productos); $i++) { 
        $resp = $pedidoManager -> insertProductos($id_pedido, $productos[$i]['ref'], $productos[$i]['cantidad']);
    }


    echo json_encode($resp);












}


?>