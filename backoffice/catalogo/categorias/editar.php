<?php

require_once __DIR__ . '/../../security/controlAccess.php';
require_once __DIR__ . '/../../model/managers/CategoryManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$categoryManager = new CategoryManager();

$category = $categoryManager -> getCategoryById($_GET['id']);

?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/categorias/">Categorías</a> / Editar categoría</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title"><?php echo $category['nombre']; ?></h1>
        </div>

        <div class="content-description">
            <p>Al editar una categoría debes tener en cuenta cómo va a afectar a las subcategorías relacionadas con ella. Recuerda que si inhabilitas una categoría, también inhabilitarás las subcategorías de la categoría modificada y los productos de las subcategorías.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/">Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/subcategorias/">Subcategorías</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/nueva.php"><i class="bi bi-plus"></i> Añadir categoría</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-category">
                <!--input especifico para editar-->
                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off" value="<?php echo $category['nombre']; ?>">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea type="descripcion" class="form-input" name="descripcion" maxlength="250"><?php echo $category['descripcion']; ?></textarea>
                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/250</span>
                    </div>
                </div>

                <p class="form-label">Estado</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector <?php if($category['estado'] == 0) echo 'inactivo'; ?>">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="estado" class="form-status-checkbox" <?php if($category['estado'] == 1) echo 'checked'; ?> value="yes">
                    <span id="status-info" class="form-admin-status-info"><?php if($category['estado'] == 0) echo 'Inactivo'; else {echo 'Activo';} ?></span>
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

                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/categorias/">Cancelar</a></button>
                    
                    <button class="form-submit-btn" type="submit">Editar categoría</button>
                </div>

            </form>

        </div>

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
        <p class="form-delete-text-info">Borrar una categoría implica modificar todas las subcategorías relacionados con esta categoría. Si lo que quieres es que no se muestre en la tienda, puedes poner la categoría inactiva. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar <?php echo $category['nombre']; ?></span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar <?php echo $category['nombre']; ?>">

                <p class="input-error-info">Debes escribir el texto exacto.</p>
            </div>
            <div class="form-submit">
                <button class="form-delete-btn" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleStatusInput.js"; ?>"></script>
<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleDeletePopup.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/categorias/categorias.js"; ?>"></script>

<?php require_once __DIR__ . '/../../footer.php'; ?>