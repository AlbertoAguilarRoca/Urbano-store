<?php

require_once __DIR__ . '/../security/controlAccess.php';
include_once __DIR__ . '/../model/managers/ClientManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

$clientManager = new ClientManager();

$cliente = $clientManager -> getClientById($_GET['id_cliente']);

?>

<?php require_once __DIR__ . '/../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/clientes/">Clientes</a> / Editar cliente</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title"><?php echo $cliente['nombre']." ".$cliente['apellido1']." ".$cliente['apellido2']  ?></h1>
        </div>

        <div class="content-description">
            <p>Aquí podrás editar la información de los clientes. La contraseña no podrás verla, tan solo podrás cambiarla por una nueva.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/clientes/">Clientes</a></li>
                    <li><a href="http://localhost/urban/backoffice/clientes/nuevo.php" ><i class="bi bi-plus"></i> Añadir cliente</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-cliente">

                <input type="hidden" name="_method" value="put">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off" value="<?php echo $cliente['nombre']; ?>">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="text">
                    <label for="apellido1" class="form-label">Primer apellido *</label>
                    <input type="text" class="form-input" name="apellido1" maxlength="50" autocomplete="off" value="<?php echo $cliente['apellido1']; ?>">

                    <p class="input-error-info">El primer apellido no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="apellido2" class="form-label">Segundo apellido</label>
                    <input type="text" class="form-input" name="apellido2" maxlength="50" autocomplete="off" value="<?php echo $cliente['apellido2']; ?>">

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="email">
                    <label for="email" class="form-label">Email *</label>
                    <input type="text" class="form-input" name="email" maxlength="100" autocomplete="off" value="<?php echo $cliente['email']; ?>">

                    <p class="input-error-info">Formato de email incorrecto.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group pb-5">
                    <label class="form-label">Género *</label>
                    
                    <input type="radio" name="genero" value="H" <?php if($cliente['genero'] == 'H'){echo 'checked';} ?>>
                    <span class="form-span">Hombre</span>
                    <input type="radio" name="genero" value="M" <?php if($cliente['genero'] == 'M'){echo 'checked';} ?>>
                    <span class="form-span">Mujer</span>
                    <input type="radio" name="genero" value="O" <?php if($cliente['genero'] == 'O'){echo 'checked';} ?>>
                    <span class="form-span">Otro</span>
                </div>

                <div class="form-group pb-5" data-required="false" data-type="password-new">
                    <label for="password1" class="form-label">Contraseña *</label>
                    <input type="password" class="form-input" name="password" data-element="password2" id="password1">
                    <div class="form-icon-password">
                        <div class="eye" id="eye"><i class="bi bi-eye"></i></div>
                        <button type="button" class="generatePass" id="generatePass"><i class="bi bi-shuffle"></i> Generar</button>
                    </div>

                    <p class="input-error-info"></p>
                    <div class="form-group-info">
                        <span>La contraseña debe tener al menos 8 caracteres,contando con una mayúscula y un número.</span>
                    </div>

                </div>

                <div class="form-group pb-5">
                    <label for="password2" class="form-label">Repetir contraseña *</label>
                    <input type="password" class="form-input" name="password2" id="password2">
                </div>

                <div class="form-group">
                    <label class="form-label">Fecha de nacimiento</label>
                    
                    <div class="form-select-date">
                        <?php 
                            $fecha_nac = explode('-', $cliente['fecha_nacimiento']);
                        ?>
                        <div class="form-select-input">
                            <span class="form-span">Día</span>
                            <select name="dia" id="dia" class="form-select-date-input">
                                <option selected disabled value=""></option>
                                <?php 
                                    for ($i=1; $i <= 31; $i++) { 
                                        if($i == intval($fecha_nac[2])) {
                                            echo "<option value='$i' selected>$i</option>";
                                        } else {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-select-input">
                            <span class="form-span">Mes</span>
                            <select name="mes" id="mes" class="form-select-date-input">
                                <option selected disabled value=""></option>
                                <?php 
                                    for ($i=1; $i <= 12; $i++) { 
                                        if($i == intval($fecha_nac[1])) {
                                            echo "<option value='$i' selected>$i</option>";
                                        } else {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-select-input">
                            <span class="form-span">Año</span>
                            <select name="year" id="year" class="form-select-date-input">
                                <option selected disabled value=""></option>
                                <?php
                                    $currentYear = intval(date('Y'))-16;
                                    $maxYear = $currentYear - 100; //Hasta cien años 
                                    for ($i=$currentYear; $i >= $maxYear; $i--) { 
                                        if($i == intval($fecha_nac[0])) {
                                            echo "<option value='$i' selected>$i</option>";
                                        } else {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                    </div>

                </div>

                <p class="form-label">Subscrito newsletter</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector <?php if($cliente['subscrito'] == 0) {echo 'inactivo';} ?>">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="subscrito" class="form-status-checkbox" <?php if($cliente['subscrito'] == 1) {echo 'checked';} ?> value="yes">
                    <span id="status-info" class="form-admin-status-info"><?php if($cliente['subscrito'] == 0) {echo 'Inactivo';} else {echo 'Activo';} ?></span>
                </div>

                <div class="form-group pb-5">
                    <label for="invitado" class="form-label">Invitado</label>
                    <input type="checkbox" name="invitado" id="invitado" value="yes" <?php if($cliente['invitado'] == 1) {echo 'checked';} ?>>
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
                    <button class="form-submit-btn" type="submit">Editar cliente</button>
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
        <p class="form-delete-text-info">Borrar un cliente implica modificar todos los pedidos con los que está relacionado. ¿Deseas continuar?</p>
        <p class="form-delete-text-info">Escribe '<span class="type-delete" id="type-delete">Eliminar <?php echo $cliente['nombre']; ?></span>' para continuar.</p>
        <form id="form-delete">
            <div class="form-group" data-required="true" data-type="delete">
                <input type="text" class="form-input" name="delete" autocomplete="off" data-content-delete="Eliminar <?php echo $cliente['nombre']; ?>">

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
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/clientes/clientes.js"; ?>"></script>

<?php require_once __DIR__ . '/../footer.php'; ?>