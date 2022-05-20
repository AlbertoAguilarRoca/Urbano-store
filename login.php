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

    <h1 class="form_area_title">Login</h1>
    <p class="form_area_info">Conéctate para beneficiarte de ofertas especiales y ventajas exclusivas.</p>

    <div class="form-container">

        <div class="form-message" id="form-message">
            <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
            <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
        </div>

        <form class="form-element" id="form-cliente">
            <div class="form-group" data-required="true" data-type="email">
                <label for="email" class="form-label">Email *</label>
                <input type="text" class="form-input" name="email" maxlength="100" autocomplete="off" value="<?php if(isset($_SESSION['cliente'])) {echo $_SESSION['cliente']['email'];}  ?>">

                <p class="input-error-info">Formato de email incorrecto.</p>
            </div>

            <div class="form-group pb-5" data-required="true" data-type="text">
                <label for="password1" class="form-label">Contraseña *</label>
                <input type="password" class="form-input" name="password" data-element="password2" id="password1" value="<?php if(isset($_SESSION['cliente'])) {echo $_SESSION['cliente']['password'];}  ?>">
                <div class="form-icon-password">
                    <div class="eye" id="eye"><i class="bi bi-eye"></i></div>
                </div>

                <p class="input-error-info">Escribe tu contraseña.</p>
            </div>

            <div class="form-submit">
                <button class="form-submit-btn" type="submit">Iniciar sesión</button>
            </div>
        </form>
    </div>

    <p>¿No tienes cuenta? <a href="http://localhost/urban/registro.php" class="registro_link">Regístrate</a></p>

</div>

<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/login.js"; ?>"></script>
<?php require_once __DIR__ . '/./footer.php'; ?>