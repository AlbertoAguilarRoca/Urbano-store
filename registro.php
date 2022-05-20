<?php 
include_once __DIR__ . './security/ControlAcceso.php';
$control = new ControlAcceso();
if($control -> getUser() != null) {
    header("Location: /urban/index.php");
    exit;
}

require_once __DIR__ . '/./head.php'; 
?>


    <div class="form_area">

        <h1 class="form_area_title">Registrate</h1>
        <p class="form_area_info">Es tu oportunidad de acumular puntos y usarlos como más te guste. Es nuestra forma de invitarte al equipo Urbano.</p>

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
                    <label class="form-label gender">Género *</label>
                    
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

                <input type="checkbox" checked name="newsletter" value="yes">
                <label for="newsletter" class="form-label">¿Deseas recibir newsletters informativas?</label>

                <div class="form-group pb-5" data-required="true" data-type="politica-datos">

                    <p class="politica_datos">Su información personal será procesada por BOARDRIDERS Europe de acuerdo con su Política de privacidad con el fin de ofrecerle o proporcionarle nuestros productos y servicios, incluyendo nuestro programa de fidelidad, y mantenerle informado sobre nuestras novedades y colecciones en conexión con nuestras marcas, especialmente URBANO. Podrá cancelar la suscripción en cualquier momento si ya no deseara recibir información u ofertas de una de nuestras marcas. También podría solicitar acceder, corregir o eliminar su información personal, y tendrá derecho a la portabilidad de los datos.</p>

                    <input class="form-checkbox" type="checkbox" name="politica-datos" value="yes">
                    <label for="politica-datos" class="form-label">Para continuar, declaro aceptar y entender la Política de privacidad y seguridad y los Términos de Uso de la Página</label>
                    <p class="input-error-info">Debes aceptar nuestras políticas.</p>
                </div>

                <div class="form-submit">
                    <button class="form-submit-btn" type="submit">Registro</button>
                </div>

            </form>

    </div>

<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/registro.js"; ?>"></script>
<?php require_once __DIR__ . '/./footer.php'; ?>