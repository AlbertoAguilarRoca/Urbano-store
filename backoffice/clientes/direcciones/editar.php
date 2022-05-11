<?php

require_once __DIR__ . '/../../security/controlAccess.php';
require_once __DIR__ . '/../../model/managers/DireccionManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$direccionManager = new DireccionManager();

$dataDireccion = $direccionManager -> getDireccionById($_GET['id']);

?>

<?php require_once __DIR__ . '/../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/clientes/">Clientes</a> / <a href="http://localhost/urban/backoffice/clientes/direcciones/">Direcciones</a> / Editar dirección</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Editar dirección</h1>
        </div>

        <div class="content-description">
            <p>Las direcciones están directamente asociadas con un único cliente. Cada cliente podrá añadir / asociar tantas direcciones como desee a su cuenta. En caso de ser una dirección de empresa, deberá seleccionar la opción de "Empresa" e incluir su NIF y la razón social.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/clientes/">Clientes</a></li>
                    <li><a href="http://localhost/urban/backoffice/clientes/direcciones/">Direcciones</a></li>
                    <li><a href="http://localhost/urban/backoffice/clientes/direcciones/nuevo.php"><i class="bi bi-plus"></i> Añadir dirección</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-direccion">

                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="email">
                    <label for="email" class="form-label">Email de cliente *</label>
                    <input type="text" class="form-input" name="email" maxlength="100" autocomplete="off" value="<?php echo $dataDireccion['email']; ?>">

                    <p class="input-error-info">Formato de email incorrecto.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group pb-5">
                    <label for="empresa" class="form-label">¿Es una dirección de empresa?</label>
                    <input type="checkbox" 
                        <?php if ($dataDireccion['es_empresa'] == '1') {
                            echo 'checked';
                        } ?> 
                    name="empresa" id="empresa" value="yes">
                    <div class="form-group-info">
                        <span>Si es una dirección de empresa, haz check y rellena la información necesaria.</span>
                    </div>
                </div>

                <div class="form-company-client" id="company-client-info">

                    <div class="form-group" data-type="nif">
                        <label for="nif" class="form-label">CIF / NIF *</label>
                        <input type="text" class="form-input" name="nif" maxlength="10" autocomplete="off" value="<?php echo $dataDireccion['nif']; ?>">

                        <p class="input-error-info">Formato de NIF incorrecto.</p>

                        <div class="form-group-info">
                            <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                            <span class="input-length-counter">0/10</span>
                        </div>
                    </div>

                    <div class="form-group" data-type="text">
                        <label for="razon-social" class="form-label">Razón social *</label>
                        <input type="text" class="form-input" name="razon-social" maxlength="100" autocomplete="off" value="<?php echo $dataDireccion['razon_social']; ?>">

                        <p class="input-error-info">La razón social no puede estar vacía.</p>

                        <div class="form-group-info">
                            <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                            <span class="input-length-counter">0/100</span>
                        </div>
                    </div>

                </div>


                <div class="form-group" data-required="true" data-type="text">
                    <label for="direccion" class="form-label">Dirección *</label>
                    <input type="text" class="form-input" name="direccion" maxlength="100" autocomplete="off" value="<?php echo $dataDireccion['direccion']; ?>">

                    <p class="input-error-info">Debes indicar una dirección.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion2" class="form-label">Dirección 2</label>
                    <input type="text" class="form-input" name="direccion2" maxlength="25" autocomplete="off" value="<?php echo $dataDireccion['direccion2']; ?>">

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/25</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="postal">
                    <label for="codigo-postal" class="form-label">Código postal *</label>
                    <input type="text" class="form-input" name="codigo-postal" maxlength="5" autocomplete="off" value="<?php echo $dataDireccion['codigo_postal']; ?>">

                    <p class="input-error-info">Formato de código postal erróneo.</p>

                    <div class="form-group-info">
                        <span>Solo están permitidos los formatos númericos.</span>
                        <span class="input-length-counter">0/5</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="select">
                    <label for="provincia" class="form-label">Provincia *</label>
                    <select class="form-select" name="provincia" id="provincias" data-selected="<?php echo $dataDireccion['provincia']; ?>">
                        <option value="" selected disabled>-- Seleccionar provincia --</option>

                    </select>
                    <p class="input-error-info">Debes seleccionar una provincia.</p>
                    <div class="form-group-info">
                        <span>En caso de no ver datos, espera un segundo y recarga la página.</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="select">
                    <label for="localidad" class="form-label">Municipio *</label>
                    <select class="form-select" name="localidad" id="localidad" data-selected-city="<?php echo $dataDireccion['localidad']; ?>">
                        

                    </select>
                    <p class="input-error-info">Debes seleccionar un municipio.</p>
                    <div class="form-group-info">
                        <span>Si después de realizar la selección de la provincia, no ves ningún dato, espera un segundo y vuelve a realizarla.</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="telefono">
                    <label for="telefono" class="form-label">Teléfono *</label>
                    <input type="text" class="form-input" name="telefono" maxlength="20" autocomplete="off" value="<?php echo $dataDireccion['telefono']; ?>">

                    <p class="input-error-info">Formato de teléfono no válido.</p>

                    <div class="form-group-info">
                        <span>El único caracter permitido es el '+' al principio del número. Incluye el teléfono sin espacios ni guiones.</span>
                        <span class="input-length-counter">0/20</span>
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
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/clientes/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Editar dirección</button>
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
        <p class="form-delete-text-info">Al borrar la dirección se eliminarán los datos para siempre. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar dirección</span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar dirección">

                <p class="input-error-info">Debes escribir el texto exacto.</p>
            </div>
            <div class="form-submit">
                <button class="form-delete-btn" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleDeletePopup.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/clientes/direcciones.js"; ?>"></script>

<?php require_once __DIR__ . '/../../footer.php'; ?>