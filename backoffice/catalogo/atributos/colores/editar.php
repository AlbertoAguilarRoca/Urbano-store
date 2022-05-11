<?php

require_once __DIR__ . '/../../../security/controlAccess.php';
include_once __DIR__ . '../../../../model/managers/ColorManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$color = new ColorManager();

$colorData = $color -> getColorById($_GET['id']);


?>

<?php require_once __DIR__ . '/../../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/atributos/colores/">Colores</a> / Editar</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Editar color</h1>
        </div>

        <div class="content-description">
            <p>Los colores permiten a los usuarios de la tienda filtrar los productos por los colores que deseen. Puedes añadir tantos colores como quieras, pero en los productos solo podrás asociar un color: el color predominante.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/colores" class="active-item">Colores</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/tallas/">Tallas</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/genero/" >Generos</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-atributos" data-form="color">
                <!--input especifico para editar-->
                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="color">
                    <label for="nombre" class="form-label">Elige el color *</label>
                    <input type="color" class="form-color" name="codigo_hex" value="<?php echo $colorData['codigo_hex']; ?>">

                    <p class="input-error-info">Debes elegir un color único.</p>
                </div>

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="25" autocomplete="off" value="<?php echo $colorData['nombre']; ?>">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/25</span>
                    </div>
                </div>

                <div class="form-submit">
                    <?php 
                        //Solo los administradores podrán borrar
                        $permiso = intval($_SESSION['user']['permiso']);
                        if($permiso == 1) { 
                    ?>
                    <button class="form-delete-btn" type="button">Eliminar</button>
                    <?php 
                        }
                    ?>
                    <button class="form-submit-btn" type="submit">Editar color</button>
                </div>

            </form>

        </div>

        <!--datos de los atributos-->

        <div class="content-data">

            <?php 
                

                echo '<h2 class="content-data-title">Colores ('. $color -> getColorsLength() .')</h2>';
            ?>

            <div class="table-container">
            <table class="table-element table-atributes">
                <thead class="table-header">
                    <tr>
                        <th>
                            Nombre
                        </th>
                        <th class='centered'>
                            Color
                        </th>
                        <th class="centered">Acciones</th>
                    </tr>
                </thead>

                <tbody class="table-body">

                    <?php
                    $resultado = $color -> getAllColors();

                    for ($i = 0; $i < $resultado -> num_rows; $i++) {
                        $fila = $resultado -> fetch_assoc();

                        echo "<tr>
                            <td>" . $fila['nombre'] . "</td>
                            <td> <div class='th_color' style='background-color: " . $fila['codigo_hex'] . "'></div> </td>
                            <td class='centered'>
                                <button class='table-btn-edit'>
                                    <a href='http://localhost/urban/backoffice/catalogo/atributos/colores/editar.php?id=" . $fila['id'] . "'>
                                        <i class='bi bi-pencil-square'></i>
                                    </a>
                                </button>
                            </td>
                        </tr>";
                    }

                    ?>

                </tbody>
            </table>
            </div>

        </div>

        <!--fin datos de los atributos-->

    </div>
</div>

</div> <!--Final del container principal-->

<!-- area de confirmación de borrado -->
<div class="overlay-delete">
    <button id="close-form-delete" class="close-form-delete">
        <i class="bi bi-x-lg"></i>
    </button>
    <div class="confirm-delete">
        <div class="icon-warning">
            <i class="bi bi-exclamation-octagon"></i>
        </div>
        <h2>¿Seguro que deseas eliminar?</h2>
        <p class="form-delete-text-info">Borrar color implica modificar todos los productos relacionados con dicho color. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar <?php echo $colorData['nombre']; ?></span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar <?php echo $colorData['nombre']; ?>">

                <p class="input-error-info">Debes escribir el texto exacto.</p>
            </div>
            <div class="form-submit">
                <button class="form-delete-btn" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleDeletePopup.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/atributos/colores.js"; ?>"></script>

<?php require_once __DIR__ . '/../../../footer.php'; ?>