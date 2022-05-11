<?php

require_once __DIR__ . '/../../security/controlAccess.php';
require_once __DIR__ . '/../../model/managers/BrandManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$brandManager = new BrandManager();

$marca = $brandManager -> getBrandById($_GET['id']);

?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/marcas/">Marcas</a> / Editar marca</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title"><?php echo $marca['nombre']; ?></h1>
        </div>

        <div class="content-description">
            <p>Al editar una marca debes tener en cuenta cómo va a afectar a los productos relacionados con ellas. Recuerda que si inhabilitas una marca, también inhabilitarás los productos de la marca modificada.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/marcas/">Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/marcas/nuevamarca.php"><i class="bi bi-plus"></i> Añadir marca</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-brands">
                <!--input especifico para editar-->
                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off" value="<?php echo $marca['nombre']; ?>">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea type="descripcion" class="form-input" name="descripcion" maxlength="250"><?php echo $marca['descripcion']; ?></textarea>
                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/250</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="proveedor" class="form-label">Contacto de proveedor</label>
                    <input type="text" class="form-input" name="proveedor" maxlength="50" value="<?php echo $marca['contacto']; ?>">

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <p class="form-label">Estado</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector <?php if($marca['estado'] == 0) echo 'inactivo'; ?>">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="estado" class="form-status-checkbox" <?php if($marca['estado'] == 1) echo 'checked'; ?> value="yes">
                    <span id="status-info" class="form-admin-status-info"><?php if($marca['estado'] == 0) echo 'Inactivo'; else {echo 'Activo';} ?></span>
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

                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/marcas/">Cancelar</a></button>
                    
                    <button class="form-submit-btn" type="submit">Editar marca</button>
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
        <p class="form-delete-text-info">Borrar una marca implica modificar todos los productos relacionados con esta marca. Si lo que quieres es que no se muestre en la tienda, puedes poner la marca inactiva. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar <?php echo $marca['nombre']; ?></span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar <?php echo $marca['nombre']; ?>">

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
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/marcas/marcasEditar.js"; ?>"></script>

<?php require_once __DIR__ . '/../../footer.php'; ?>