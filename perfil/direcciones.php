<?php
    include_once __DIR__ . '/../security/ControlAcceso.php';
    $control = new ControlAcceso();
    if($control -> getUser() == null) {
        header("Location: /urban/index.php");
        exit;
    }

    require_once __DIR__ . '/../head.php';
    

    //me traigo las direcciones del cliente
    include_once __DIR__ . '/../backoffice/model/managers/DireccionManager.php';
    $direccionManager = new DireccionManager();
    $direcciones = $direccionManager -> getDireccionesByClient($_SESSION['cliente']['id_cliente']);
?>

<div class="client_content">

    <button class="client_logout"><a href="http://localhost/urban/logout.php">Cerrar sesión</a></button>

    <h1>Mis direcciones</h1>
    <p>Aquí se muestran todas las direcciones que has guardado.</p>

    <div class="client_data">
        <div class="client_data_element">
    <?php 
        if($direcciones -> num_rows == 0) {
            echo '<p>No tienes ninguna dirección guardada.</p>';
        } else {

            for($i = 0; $i < $direcciones -> num_rows; $i++) {
                $fila = $direcciones -> fetch_assoc();
                echo '<ul class="client_data_list">';
                if($fila['es_empresa'] == '1') {
                    echo 
                        "<li class='client_data_list_item'>Cuenta de empresa</li>
                        <li class='client_data_list_item'>NIF/CIF: ".$fila['nif']."</li>
                        <li class='client_data_list_item'>Razón Social: ".$fila['razon_social']."</li>";
                }
                echo 
                    "<li class='client_data_list_item'>Dirección: ".$fila['direccion']."</li>
                    <li class='client_data_list_item'>Dirección 2: ".$fila['direccion2']."</li>
                    <li class='client_data_list_item'>Código Postal: ".$fila['codigo_postal']."</li>
                    <li class='client_data_list_item'>Provincia: ".$fila['provincia']."</li>
                    <li class='client_data_list_item'>Localidad: ".$fila['localidad']."</li>
                    <li class='client_data_list_item'>Teléfono: ".$fila['telefono']."</li></ul>";

            }

        }
    
    ?> 
        </div>
    </div>

    <div class="client_add_direction">

        <h2>Añadir una dirección</h2>

        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-direccion">

                <input type="hidden" name="guardada" value="yes" >

                <div class="form-group pb-5">
                    <label for="empresa" class="form-label">¿Es una dirección de empresa?</label>
                    <input type="checkbox" name="empresa" id="empresa" value="yes">
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

                <div class="form-group" data-required="true" data-type="select">
                    <label for="provincia" class="form-label">Provincia *</label>
                    <select class="form-select" name="provincia" id="provincias">
                        <option value="" selected disabled>-- Seleccionar provincia --</option>

                    </select>
                    <p class="input-error-info">Debes seleccionar una provincia.</p>
                    <div class="form-group-info">
                        <span>En caso de no ver datos, espera un segundo y recarga la página.</span>
                    </div>
                </div>

                <div class="form-group" data-required="true" data-type="select">
                    <label for="localidad" class="form-label">Municipio *</label>
                    <select class="form-select" name="localidad" id="localidad">
                        

                    </select>
                    <p class="input-error-info">Debes seleccionar un municipio.</p>
                    <div class="form-group-info">
                        <span>Si después de realizar la selección de la provincia, no ves ningún dato, espera un segundo y vuelve a realizarla.</span>
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
                    <button class="form-submit-btn" type="submit">Añadir dirección</button>
                </div>

            </form>

        </div>


    </div>

</div>

<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/js/direcciones.js"; ?>"></script>
<?php require_once __DIR__ . '/../footer.php'; ?>