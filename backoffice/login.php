<?php 

    require_once __DIR__.'/security/controlAccess.php';

    $controlAccess = new ControlAccess();
    //Si accedo al login estado logeado vuelvo a administracion
    if($controlAccess -> getUser() != null) {
        header("Location: /urban/backoffice/");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Urban Clothes Admin Zone</title>
</head>

<body>
    <div class="login-admin">

        <div class="error-area" id="error-area">
            <p id="error-mensaje"></p>
        </div>

        <div class="login-hello">
            <h1><span>Hola,</span>Bienvenido de nuevo</h1>
        </div>

        <div class="login-container">

            <div class="login-logo">
                <img src="http://localhost/urban/src/img/logo.svg" alt="Logo Urbano">
            </div>

            <div class="login-box">
                <form id="form">
                    <label for="email" class="label-form" id="label-email">Correo electronico *</label>
                    <input type="text" name="email" id="email" autocomplete="off" value="<?php if (isset($_COOKIE['email'])) {
                                                                                                        echo $_COOKIE['email'];
                                                                                                    } ?>">
                    <label for="password" class="label-form" id="label-password">Contraseña *</label>
                    <div class="password-input">
                        <input type="password" name="password" id="password" value="<?php if (isset($_COOKIE['pass'])) {
                                                                                                            echo $_COOKIE['pass'];
                                                                                                        } ?>">
                        <div class="eye" id="eye"><i class="bi bi-eye"></i></div>
                    </div>
                    <div class="submit-area">
                        <div class="check-area">
                            <input type="checkbox" name="remember" id="remember" value="yes" <?php if (isset($_COOKIE['email'])) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                            <label for="remember" class="label-form">Recuérdame</label>
                        </div>

                        <button type="submit" class="btn-submit">Acceder</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="login-footer">
            <p><a href="#">¿Has olvidado tu contraseña?</a></p>
            <p>
                <a href="../index.php">
                    <i class="bi bi-arrow-left"></i> Volver a la tienda.
                </a>
            </p>
        </div>
    </div>

    <script src="js/AdminLogin.js" type="module"></script>


</body>
</html>