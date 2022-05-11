<?php

require_once __DIR__ . '/../security/controlAccess.php';

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

<?php require_once __DIR__ . '/../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/clientes/">Clientes</a> / Añadir cliente</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Añadir cliente</h1>
        </div>

        <div class="content-description">
            <p>Normalmente serán los propios clientes quienes se registren a través de la página web, pero si es necesario, desde la zona de administración también se pueden añadir nuevos clientes manualmente.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/clientes/">Clientes</a></li>
                    <li><a href="http://localhost/urban/backoffice/clientes/nuevo.php" class="active-item"><i class="bi bi-plus"></i> Añadir cliente</a></li>
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

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="text">
                    <label for="apellido1" class="form-label">Primer apellido *</label>
                    <input type="text" class="form-input" name="apellido1" maxlength="50" autocomplete="off">

                    <p class="input-error-info">El primer apellido no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="apellido2" class="form-label">Segundo apellido</label>
                    <input type="text" class="form-input" name="apellido2" maxlength="50" autocomplete="off">

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="email">
                    <label for="email" class="form-label">Email *</label>
                    <input type="text" class="form-input" name="email" maxlength="100" autocomplete="off">

                    <p class="input-error-info">Formato de email incorrecto.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/100</span>
                    </div>
                </div>

                <div class="form-group pb-5">
                    <label class="form-label">Género *</label>
                    
                    <input type="radio" name="genero" value="H" checked>
                    <span class="form-span">Hombre</span>
                    <input type="radio" name="genero" value="M">
                    <span class="form-span">Mujer</span>
                    <input type="radio" name="genero" value="O">
                    <span class="form-span">Otro</span>
                </div>

                <div class="form-group pb-5" data-required="true" data-type="password-new">
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

                        <div class="form-select-input">
                            <span class="form-span">Día</span>
                            <select name="dia" id="dia" class="form-select-date-input">
                                <option selected disabled value=""></option>
                                <?php 
                                    for ($i=1; $i <= 31; $i++) { 
                                        echo "<option value='$i'>$i</option>";
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
                                        echo "<option value='$i'>$i</option>";
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
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>

                    </div>

                </div>

                <p class="form-label">Subscrito newsletter</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="subscrito" class="form-status-checkbox" checked value="yes">
                    <span id="status-info" class="form-admin-status-info">Activo</span>
                </div>

                <div class="form-group pb-5">
                    <label for="invitado" class="form-label">Invitado</label>
                    <input type="checkbox" name="invitado" id="invitado" value="yes">
                </div>

                <div class="form-submit">
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/clientes/">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Añadir cliente</button>
                </div>

            </form>

        </div>

    </div>
</div>

</div> <!--Final del container principal-->

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleStatusInput.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/clientes/clientes.js"; ?>"></script>

<?php require_once __DIR__ . '/../footer.php'; ?>