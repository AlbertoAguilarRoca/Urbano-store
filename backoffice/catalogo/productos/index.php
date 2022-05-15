<?php

require_once __DIR__ . '/../../security/controlAccess.php';
require_once __DIR__ . '/../../model/managers/ProductManager.php';
include_once  __DIR__ . '/../../helpers/statusConverter.php';


$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

/* Comprobaciones para el order de la tabla */
$order = 'estado';
$sort = 'ASC';

if (isset($_GET['order'])) {
    $order = $_GET['order'];
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    $sort == 'ASC' ? $sort = 'DESC' : $sort = 'ASC';
}

/* Inicializacion del manager */
$productManager = new ProductManager();

/* Comprobaciones para la paginacion */
$pagina_actual = 1;

$registros_por_pagina = 100;

$total_registros_productos = 0;
if (isset($_GET['search'])) {
    $total_registros_productos = $productManager->getProductsSearchedLength($_GET['search']);
} else {
    $total_registros_productos = $productManager->getProductsLength();
}

$paginas_totales = ceil($total_registros_productos / $registros_por_pagina);

if (isset($_GET['page'])) {
    $pagina_actual = $_GET['page'];
}

//Indica el anterior bloque que se mostro.
$ultimo_inicio = $pagina_actual - 1;

$inicio = $ultimo_inicio * $registros_por_pagina;


?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / Productos</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Productos</h1>
        </div>

        <div class="content-description">
            <p>En esta página podrás ver todo el catálogo de productos, activos e inactivos, con stock o sin él. Desde aquí podrás acceder a la edición de los mismos, así como la creación de nuevos. Si quieres ver el stock pormenorizado por tallas, puedes verlo en la sección de stock.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/productos/" class="active-item">Overview</a></li>

                    <?php
                    //Los usuarios con permiso de 'content' no podrán añadir nuevos productos
                    $permiso = intval($_SESSION['user']['permiso']);
                    if ($permiso == 1 || $permiso == 2) {
                    ?>

                        <li><a href="http://localhost/urban/backoffice/catalogo/productos/nuevo.php"><i class="bi bi-plus"></i> Añadir producto</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="content-filters">
            <div class="content-search-box">
                <form class="form-search" id="form-search">
                    <div class="form-group" data-required="true" data-type="search">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-input" name="search" placeholder="Busca por referencia del producto" autocomplete="off">
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
                                        echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.referencia';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }

                                    ?>
                                ">
                                    Referencia <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.nombre';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Nombre <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=m.nombre';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Marca <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=sc.nombre';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Subcategoría <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.precio';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Precio (sin IVA) <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.iva';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    IVA <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            Precio (con IVA)
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.fecha_creacion';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Fecha creación <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th>
                            <button>
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=g.nombre';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Género <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                            </form>
                        </th>
                        <th class="centered">
                            Stock total
                        </th>
                        <th>
                            <button class="centered">
                                <a href="
                                <?php
                                    echo 'http://localhost' . htmlspecialchars($_SERVER['PHP_SELF']) . '?page=' . $pagina_actual . '&sort=' . $sort . '&order=p.estado';

                                    if (isset($_GET['search'])) {
                                        echo '&search=' . $_GET['search'];
                                    }
                                    ?>
                                ">
                                    Estado <span><i class="bi bi-caret-down-fill"></i></span>
                                </a>
                            </button>
                        </th>
                        <th class="centered">Editar</th>
                    </tr>
                </thead>

                <tbody class="table-body">

                    <?php
                    $totalProductos = [];

                    if (isset($_GET['search'])) {
                        $totalProductos = $productManager->getProductsSearched($order, $sort, $inicio, $registros_por_pagina, $_GET['search']);
                    } else {
                        $totalProductos = $productManager->getProducts($order, $sort, $inicio, $registros_por_pagina);
                    }

                    for ($i = 0; $i < count($totalProductos); $i++) {
                        echo "<tr>
                            <td>" . $totalProductos[$i]['referencia'] . "</td>
                            <td>" . $totalProductos[$i]['nombre'] . "</td>
                            <td>" . $totalProductos[$i]['marca'] . "</td>
                            <td>" . $totalProductos[$i]['subcategoria'] . "</td>
                            <td>" . $totalProductos[$i]['precio'] . " €</td>
                            <td>" . $totalProductos[$i]['iva'] . "</td>
                            <td>" . $totalProductos[$i]['precio_con_iva'] . " €</td>
                            <td>" . $totalProductos[$i]['fecha_creacion'] . "</td>
                            <td>" . $totalProductos[$i]['genero'] . "</td>
                            <td class='centered'>" . $totalProductos[$i]['stock_total'] . "</td>
                            <td class='centered'>" . convertirEstado($totalProductos[$i]['estado']) . "</td>
                            <td class='centered'>
                                <button class='table-btn-edit'>
                                    <a href='http://localhost/urban/backoffice/catalogo/productos/editar.php?ref=" . $totalProductos[$i]['referencia'] . "'>
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

                        if ($final_registro > $total_registros_productos) {
                            $final_registro = $total_registros_productos;
                        }

                        echo $inicio_registro . "-" . $final_registro . " de " . $total_registros_productos;
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
<?php require_once __DIR__ . '/../../footer.php'; ?>