<?php

require_once __DIR__ . '/../../security/controlAccess.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

if($_SESSION['user']['permiso'] == '3') {
    header("Location: /urban/backoffice/catalogo/marcas/index.php");
    exit;
}

?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/marcas/">Marcas</a> / Añadir marca</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Añadir marca</h1>
        </div>

        <div class="content-description">
            <p>Una vez que crees la marca, podrás anexionar todos los productos de la misma que desees. Añadir una descripción y una forma de contacto con el proveedor puede ser útil para una rápida identificación y contacto de la misma.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/marcas/">Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/marcas/nuevamarca.php" class="active-item"><i class="bi bi-plus"></i> Añadir marca</a></li>
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

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea type="descripcion" class="form-input" name="descripcion" maxlength="250"></textarea>
                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/250</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="proveedor" class="form-label">Contacto de proveedor</label>
                    <input type="text" class="form-input" name="proveedor" maxlength="50">

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <p class="form-label">Estado</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="estado" class="form-status-checkbox" checked value="yes">
                    <span id="status-info" class="form-admin-status-info">Activo</span>
                </div>

                <div class="form-submit">
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/marcas/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Añadir marca</button>
                </div>

            </form>

        </div>

    </div>
</div>

</div> <!--Final del container principal-->

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleStatusInput.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/marcas/marcasManager.js"; ?>"></script>

<?php require_once __DIR__ . '/../../footer.php'; ?>