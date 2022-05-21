<?php

require_once __DIR__ . '/../security/controlAccess.php';
require_once __DIR__ . '/../model/managers/PedidoManager.php';


$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

/* Comprobaciones para el order de la tabla */
$order = 'fecha';
$sort = 'ASC';

if (isset($_GET['order'])) {
    $order = $_GET['order'];
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    $sort == 'ASC' ? $sort = 'DESC' : $sort = 'ASC';
}

/* Inicializacion del manager */
$pedidosManager = new PedidoManager();

$sql = "SELECT ref_pedido, cliente, fecha, importe, ep.nombre, metodo_pago
FROM pedidos p, estadopedido ep WHERE p.estado_pedido = ep.id";

$filtro = '';

if(isset($_GET['show'])) {
    $sql = $sql . ' AND p.estado_pedido IN ('.$_GET['show'].')';
    $filtro = $_GET['show'];
}

/* Comprobaciones para la paginacion */
$pagina_actual = 1;

$registros_por_pagina = 10;

$total_registros_pedidos = 0;
if (isset($_GET['search'])) {
    $total_registros_pedidos = $pedidosManager->getPedidosSearchLength($_GET['search'], $filtro);
} else {
    $total_registros_pedidos = $pedidosManager-> getPedidosLength($filtro);
}

$paginas_totales = ceil($total_registros_pedidos / $registros_por_pagina);

if (isset($_GET['page'])) {
    $pagina_actual = $_GET['page'];
}

//Indica el anterior bloque que se mostro.
$ultimo_inicio = $pagina_actual - 1;

$inicio = $ultimo_inicio * $registros_por_pagina;


if(isset($_GET['search'])) {
    $busqueda = $_GET['search'];
    $sql = $sql . " AND ref_pedido LIKE '%".$busqueda."%'";
}

$sql = $sql . " ORDER BY $order $sort limit $inicio, $registros_por_pagina";

$pedidos = $pedidosManager -> getPedidos($sql);

?>

<?php require_once __DIR__ . '/../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / Pedidos</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Pedidos</h1>
        </div>

        <div class="content-description">
            <p>En este área podrás gestionar los pedidos de productos de los clientes. Conforme el estado del pedido vaya evolucionando, puedes ir modificándolo para realizar una correcta gestión del pedido.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/pedidos/" <?php if(!isset($_GET['show'])) {echo 'class="active-item"';} ?>>Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/pedidos/index.php?page=1&show=1" <?php if(isset($_GET['show']) && $_GET['show'] == '1') {echo 'class="active-item"';} ?>>Confirmados</a></li>
                    <li><a href="http://localhost/urban/backoffice/pedidos/index.php?page=1&show=2,3" <?php if(isset($_GET['show']) && $_GET['show'] == '2,3') {echo 'class="active-item"';} ?>>Preparación</a></li>
                    <li><a href="http://localhost/urban/backoffice/pedidos/index.php?page=1&show=4,5" <?php if(isset($_GET['show']) && $_GET['show'] == '4,5') {echo 'class="active-item"';} ?>>En camino</a></li>
                    <li><a href="http://localhost/urban/backoffice/pedidos/index.php?page=1&show=6,7" <?php if(isset($_GET['show']) && $_GET['show'] == '6,7') {echo 'class="active-item"';} ?>>No entregados</a></li>
                </ul>
            </div>
        </div>

        <div class="content-filters">
            <div class="content-search-box">
                <form class="form-search" id="form-search">
                    <div class="form-group" data-required="true" data-type="search">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-input" name="search" placeholder="Busca por referencia de pedido" autocomplete="off">
                        <p class="input-error-info">Debes insertar mínimo tres caracteres.</p>
                    </div>
                </form>
            </div>

            <div class="content-filters-btn-box">
                <button><i class="bi bi-file-earmark-arrow-down"></i> Exportar a .xslt</button>
            </div>
        </div>

        <div class="table-container">
            <table class="table-element">
                <thead class="table-header">
                    <tr>
                        <th>
                            <button>
                                <a href="
                                    <?php
                                        echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=ref_pedido';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }

                                    ?>
                                ">
                                    Ref. pedido <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=cliente';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Ref. cliente <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            
                        </th>

                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=fecha';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Fecha <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                        </th>

                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=importe';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Importe <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                        </th>

                        <th>
                            <button class="centered">
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=nombre';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Estado pedido <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            
                        </th>

                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=metodo-pago';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Método pago <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>

                        <th class="centered">Editar</th>
                    </tr>
                </thead>

                <tbody class="table-body">

                    <?php

                    for ($i = 0; $i < $pedidos -> num_rows; $i++) {
                        $fila = $pedidos -> fetch_assoc();
                        echo "<tr>
                            <td>" . $fila['ref_pedido'] . "</td>
                            <td>" . $fila['cliente'] . "</td>
                            <td>" . $fila['fecha'] . "</td>
                            <td>" . $fila['importe'] . " €</td>
                            <td class='centered'><span class='estado_pedido' data-estado='".$fila['nombre']."'>" . $fila['nombre'] . "</span></td>
                            <td>" . $fila['metodo_pago'] . "</td>
                            <td class='centered'>
                                <button class='table-btn-edit'>
                                    <a href='http://localhost/urban/backoffice/pedidos/editar.php?ref=" . $fila['ref_pedido'] . "'>
                                        <i class='bi bi-pencil-square'></i>
                                    </a>
                                </button>
                            </td>
                        </tr>";
                    }

                    ?>

                </tbody>
            </table>
            <div class="table-pagination">

                <div class="table-pagination-info">
                    <p>
                        <?php
                        $inicio_registro = $inicio + 1;
                        $final_registro = $inicio_registro + $registros_por_pagina - 1;

                        if ($final_registro > $total_registros_pedidos) {
                            $final_registro = $total_registros_pedidos;
                        }

                        echo $inicio_registro . "-" . $final_registro . " de " . $total_registros_pedidos;
                        ?>
                    </p>
                </div>

                <div class="table-pagination-btn">


                    <?php

                    $parametros = '';

                    $url = parse_url($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);

                    //Para mantener los query params de la anterior paginacion, guardo la url, y elimino el ?page=1 del string
                    if (isset($url['query'])) {
                        $parametros = preg_replace('/page=[\d]/', '', $url['query']);

                        if (!str_starts_with($parametros, '&')) {
                            $parametros = '&' . $parametros;
                        }
                    }

                    echo "<button>
                                <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=1" . $parametros . "'>
                                    <i class='bi bi-arrow-left'></i>
                                </a>
                            </button>";

                    if ($pagina_actual - 1 > 0) {
                        $pagina_anterior = $pagina_actual - 1;
                        echo "<span>...</span><button>
                            <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=" . $pagina_anterior . $parametros . "'>
                                " . $pagina_anterior . "
                            </a>
                        </button>";
                    }

                    echo "<button>
                            <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=" . $pagina_actual . $parametros . "'>
                                " . $pagina_actual . "
                            </a>
                        </button>";

                    if ($pagina_actual + 1 <= $paginas_totales) {
                        $pagina_siguiente = $pagina_actual + 1;
                        echo "<button>
                                <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=" . $pagina_siguiente . $parametros . "'>
                                    " . $pagina_siguiente . "
                                </a>
                            </button><span>...</span>";
                    }

                    echo "<button>
                            <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?page=" . $paginas_totales . $parametros . "'>
                                <i class='bi bi-arrow-right'></i>
                            </a>
                        </button>";

                    ?>
                </div>

            </div>

        </div>
        <!--fin .table-container-->

    </div>
    <!--fin content-container-->
</div>
<!--fin .content-page-->

</div>
<!--fin del container que envuelve todo: main row-->
<script type="module" src="http://localhost/urban/backoffice/js/marcas/marcasSearchManager.js"></script>
<?php require_once __DIR__ . '/../footer.php'; ?>