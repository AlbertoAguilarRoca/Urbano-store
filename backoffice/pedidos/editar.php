<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/PedidoManager.php';
require_once __DIR__ . '/../model/managers/ClientManager.php';
require_once __DIR__ . '/../model/managers/DireccionManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$pedidoManager = new PedidoManager();
$clientManager = new ClientManager();
$direccionManager = new DireccionManager();

$infoPedido = $pedidoManager->getPedidoByRef($_GET['ref']);
$estados = $pedidoManager->getEstadosPedidos();
$infoCliente = $clientManager -> getClientById($infoPedido['cliente']);
$direccionEnv = $direccionManager -> getDireccionById($infoPedido['direccion_envio']);
$direccionFac = $direccionManager -> getDireccionById($infoPedido['direccion_factura']);
$productosPedido = $pedidoManager -> getProductosPedido($infoPedido['ref_pedido']);

?>

<?php require_once __DIR__ . '/../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/pedidos/">Pedidos</a> / Editar pedido</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Editar pedido</h1>
        </div>

        <div class="content-description">
            <p>Edita el estado del pedido para ir completando el proceso de entrega. Puedes modificar el estado del pedido a cualquiera de los mismos. Si deseas editar los datos de envío o facturación, puedes hacerlo yendo a la propia dirección.</p>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="pedido_content">

            <div class="pedido_content_row">

                <div class="pedido_content_col">

                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Estado del pedido</h2>
                        <form id="form-pedido">
                            <select name="estado" class="form-select">
                                <?php

                                    for($i=0; $i < $estados -> num_rows; $i++) {
                                        $fila = $estados -> fetch_assoc();
                                        
                                        if($fila['id'] == $infoPedido['estado_pedido']) {
                                            echo '<option selected value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
                                        } else {
                                            echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
                                        }
                                    }

                                ?>
                            </select>
                            <button type="submit" class="form-submit-btn">Modificar Estado</button>
                        </form>
                    </div>
                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Cliente</h2>
                        <ul class="pedido_list">
                            <li class="pedido_list_item"><strong>Id:</strong> <?php echo $infoPedido['cliente'] ?></li>
                            <li class="pedido_list_item"><strong>Nombre:</strong> <?php echo $infoCliente['nombre'] ?></li>
                            <li class="pedido_list_item"><strong>Primer apellido:</strong> <?php echo $infoCliente['apellido1'] ?></li>
                            <li class="pedido_list_item"><strong>egundo apellido:</strong> <?php echo $infoCliente['apellido2'] ?></li>
                            <li class="pedido_list_item"><strong>Email:</strong> <?php echo $infoCliente['email'] ?></li>
                        </ul>
                    </div>
                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Dirección de envío</h2>
                        <ul class="pedido_list">
                            <li class="pedido_list_item"><strong>Dirección:</strong> <?php echo $direccionEnv['direccion'] ?></li>
                            <li class="pedido_list_item"><strong>Dirección 2:</strong> <?php echo $direccionEnv['direccion2'] ?></li>
                            <li class="pedido_list_item"><strong>Código postal:</strong> <?php echo $direccionEnv['codigo_postal'] ?></li>
                            <li class="pedido_list_item"><strong>Provincia:</strong> <?php echo $direccionEnv['provincia'] ?></li>
                            <li class="pedido_list_item"><strong>Municipio:</strong> <?php echo $direccionEnv['localidad'] ?></li>
                            <li class="pedido_list_item"><strong>Teléfono:</strong> <?php echo $direccionEnv['telefono'] ?></li>
                        </ul>
                        <button class="pedido_area_btn"><a href="http://localhost/urban/backoffice/clientes/direcciones/editar.php?id=<?php echo $infoPedido['direccion_envio']; ?>">Editar</a></button>
                    </div>
                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Dirección de facturación</h2>
                        <ul class="pedido_list">
                            <li class="pedido_list_item"><strong>Nif:</strong> <?php echo $direccionFac['nif'] ?></li>
                            <li class="pedido_list_item"><strong>Razón Social:</strong> <?php echo $direccionFac['razon_social'] ?></li>
                            <li class="pedido_list_item"><strong>Dirección:</strong> <?php echo $direccionFac['direccion'] ?></li>
                            <li class="pedido_list_item"><strong>Dirección 2:</strong> <?php echo $direccionFac['direccion2'] ?></li>
                            <li class="pedido_list_item"><strong>Código postal:</strong> <?php echo $direccionFac['codigo_postal'] ?></li>
                            <li class="pedido_list_item"><strong>Provincia:</strong> <?php echo $direccionFac['provincia'] ?></li>
                            <li class="pedido_list_item"><strong>Municipio:</strong> <?php echo $direccionFac['localidad'] ?></li>
                            <li class="pedido_list_item"><strong>Teléfono:</strong> <?php echo $direccionFac['telefono'] ?></li>
                        </ul>
                        <button class="pedido_area_btn"><a href="http://localhost/urban/backoffice/clientes/direcciones/editar.php?id=<?php echo $infoPedido['direccion_factura']; ?>">Editar</a></button>
                    </div>
                </div>

                <div class="pedido_content_col">

                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Información del pedido</h2>
                        <ul class="pedido_list">
                            <li class="pedido_list_item"><strong>Referencia del pedido:</strong> <?php echo $infoPedido['ref_pedido'] ?></li>
                            <li class="pedido_list_item"><strong>Importe:</strong> <?php echo $infoPedido['importe'] ?></li>
                            <li class="pedido_list_item"><strong>Fecha:</strong> <?php echo $infoPedido['fecha'] ?></li>
                            <li class="pedido_list_item"><strong>Método de pago:</strong> <?php echo $infoPedido['metodo_pago'] ?></li>
                        </ul>
                    </div>
                    
                    <div class="pedido_area">
                        <h2 class="pedido_area_title">Productos del pedido</h2>
                        
                            <?php
                                for($i = 0; $i < $productosPedido -> num_rows; $i++) {
                                    $fila = $productosPedido -> fetch_assoc();

                                    echo '<ul class="prod_pedido_list"><li class="prod_pedido_list_item"><strong>Ref:</strong> '.$fila['ref_producto'].'</li>
                                    <li class="prod_pedido_list_item"><strong>Nombre:</strong> '.$fila['nombre'].'</li>
                                    <li class="prod_pedido_list_item"><strong>Color:</strong> '.$fila['color'].'</li>
                                    <li class="prod_pedido_list_item"><strong>Talla:</strong> '.$fila['talla'].'</li>
                                    <li class="prod_pedido_list_item"><strong>Cantidad:</strong> '.$fila['cantidad'].'</li></ul>';
                                }
                            ?>
                            
                        </ul>
                    </div>


                </div>



            </div>


        </div>

    </div>
</div>

</div>
<!--Final del container principal-->



<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/pedido/pedidos.js"; ?>"></script>

<?php require_once __DIR__ . '/../footer.php'; ?>