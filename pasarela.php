<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Pasarela de pago</title>
</head>

<body>

    <header class="pasarela_header">
        <div class="pasarela_header_content">
            <div class="logo_pasarela">
                <img src="http://localhost/urban/src/img/logo.svg" alt="Logo pasarela">
            </div>
            <div class="pasarela_estados activa">
                <span class="estado_numero">1</span>
                <span class="estado_texto">Datos de envío</span>
            </div>
            <div class="pasarela_estados">
                <span class="estado_numero">2</span>
                <span class="estado_texto">Pago</span>
            </div>
        </div>
    </header>

    <div class="pasarela_content">

        <div class="pasarela_content_row">

            <div class="pasarela_content_info">

                <div class="sing_in_area">
                    <button class="sign_in_pasarela"><a href="http://localhost/urban/login.php">Iniciar sesión</a></button>

                    <p class="sing_in_text_pasarela">Inicia sesión o <a href="http://localhost/urban/registro.php">Crear una cuenta</a> para agilizar el proceso de compra y disfrutar de miles de recompensas y beneficios.</p>
                </div>

                <!-- Si el cliente esta registrado y tiene direcciones guardadas, se muestran aquí -->

                <div class="form-container">

                    <div class="bloque_1" id="bloque_1">
                        <h2 class="pasarela_title">Dirección de envío</h2>
                        <form class="form-element" id="form-direccion">

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar un nombre.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/50</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="apellido1" class="form-label">Primer apellido *</label>
                                <input type="text" class="form-input" name="apellido1" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar un apellido.</p>

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

                                <p class="input-error-info">Formato de email no válido.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/100</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="direccion" class="form-label">Dirección *</label>
                                <input type="text" class="form-input" name="direccion" maxlength="100" autocomplete="off">

                                <p class="input-error-info">Debes indicar una dirección.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/100</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="direccion2" class="form-label">Dirección 2</label>
                                <input type="text" class="form-input" name="direccion2" maxlength="25" autocomplete="off">

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/25</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="postal">
                                <label for="codigo-postal" class="form-label">Código postal *</label>
                                <input type="text" class="form-input" name="codigo-postal" maxlength="5" autocomplete="off">

                                <p class="input-error-info">Formato de código postal erróneo.</p>

                                <div class="form-group-info">
                                    <span>Solo están permitidos los formatos númericos.</span>
                                    <span class="input-length-counter">0/5</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="provincia" class="form-label">Provincia *</label>
                                <input type="text" class="form-input" name="provincia" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar una provincia.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/50</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="direccion" class="form-label">Municipio *</label>
                                <input type="text" class="form-input" name="direccion" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar un municipio.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/50</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="telefono">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="text" class="form-input" name="telefono" maxlength="20" autocomplete="off">

                                <p class="input-error-info">Formato de teléfono no válido.</p>

                                <div class="form-group-info">
                                    <span>El único caracter permitido es el '+' al principio del número. Incluye el teléfono sin espacios ni guiones.</span>
                                    <span class="input-length-counter">0/20</span>
                                </div>
                            </div>

                            <div class="form-submit">
                                <button class="form-submit-btn" type="button" id="siguiente">Siguiente paso</button>
                            </div>

                    </div>

                    <div class="bloque_2 no_display" id="bloque_2">
                        <button class="back_bloque_1" id="back_bloque_1">< Volver</button>

                        <h2 class="pasarela_title">Dirección de facturación</h2>
                        <input checked type="checkbox" name="dir_facturacion" value="yes" id="dir_facturacion">
                        <label class="form-label">La dirección de facturación es la misma que la de envío</label>

                        <div class="direccion_facturacion_form no_display">
                            <div class="form-group pb-5">
                                <input type="checkbox" name="empresa" id="empresa" value="yes">
                                <label for="empresa" class="form-label">¿Es una dirección de empresa?</label>
                                <div class="form-group-info">
                                    <span>Si es una dirección de empresa, haz check y rellena la información necesaria.</span>
                                </div>
                            </div>

                            <div class="form-company-client" id="company-client-info">

                                <div class="form-group" data-type="nif">
                                    <label for="nif" class="form-label">CIF / NIF *</label>
                                    <input type="text" class="form-input" name="nif" maxlength="10" autocomplete="off">

                                    <p class="input-error-info">Formato de NIF incorrecto.</p>

                                    <div class="form-group-info">
                                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                        <span class="input-length-counter">0/10</span>
                                    </div>
                                </div>

                                <div class="form-group" data-type="text">
                                    <label for="razon-social" class="form-label">Razón social *</label>
                                    <input type="text" class="form-input" name="razon-social" maxlength="100" autocomplete="off">

                                    <p class="input-error-info">La razón social no puede estar vacía.</p>

                                    <div class="form-group-info">
                                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                        <span class="input-length-counter">0/100</span>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group" data-required="true" data-type="text">
                                <label for="direccion" class="form-label">Dirección *</label>
                                <input type="text" class="form-input" name="direccion_fac" maxlength="100" autocomplete="off">

                                <p class="input-error-info">Debes indicar una dirección.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/100</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="direccion2" class="form-label">Dirección 2</label>
                                <input type="text" class="form-input" name="direccion2_fac" maxlength="25" autocomplete="off">

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/25</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="postal">
                                <label for="codigo-postal" class="form-label">Código postal *</label>
                                <input type="text" class="form-input" name="codigo-postal_fac" maxlength="5" autocomplete="off">

                                <p class="input-error-info">Formato de código postal erróneo.</p>

                                <div class="form-group-info">
                                    <span>Solo están permitidos los formatos númericos.</span>
                                    <span class="input-length-counter">0/5</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="provincia" class="form-label">Provincia *</label>
                                <input type="text" class="form-input" name="provincia_fac" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar una provincia.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/50</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="text">
                                <label for="direccion" class="form-label">Municipio *</label>
                                <input type="text" class="form-input" name="direccion_fac" maxlength="50" autocomplete="off">

                                <p class="input-error-info">Debes indicar un municipio.</p>

                                <div class="form-group-info">
                                    <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                                    <span class="input-length-counter">0/50</span>
                                </div>
                            </div>

                            <div class="form-group" data-required="true" data-type="telefono">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="text" class="form-input" name="telefono_fac" maxlength="20" autocomplete="off">

                                <p class="input-error-info">Formato de teléfono no válido.</p>

                                <div class="form-group-info">
                                    <span>El único caracter permitido es el '+' al principio del número. Incluye el teléfono sin espacios ni guiones.</span>
                                    <span class="input-length-counter">0/20</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-submit">
                            <button class="form-submit-btn" type="submit"><i class="bi bi-paypal"></i> Pagar con Paypal</button>
                        </div>
                        </form>
                    </div>

                </div>

            </div>
            <!--FIN PASARELA CONTENT_INFO-->

            <div class="carrito_pay">

                <div class="codigo_pro">
                    <p class="codigo_title">
                        ¿Tienes un código promocional?
                    </p>
                    <input type="text" id="cod_promo" placeholder="Introducir código">
                    <button class="promo_btn" disabled>Aplicar</button>
                </div>

                <div class="subtotal_price">
                    <span>Subtotal</span>
                    <span id="sub_price"></span>
                </div>

                <div class="shipping_price">
                    <span>Envío Estandar</span>
                    <span id="shipping_price"></span>
                </div>

                <div class="total_price">
                    <div>
                        Total
                        <p class="tax_info">(21% IVA incluido)</p>
                    </div>
                    <span id="total_price"></span>
                </div>

            </div>

        </div>


    </div> <!-- fin pasarela content -->


    <script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/pasarela.js"; ?>"></script>
</body>
</html>