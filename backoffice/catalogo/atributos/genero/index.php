<?php

require_once __DIR__ . '/../../../security/controlAccess.php';
include_once __DIR__ . '../../../../model/managers/GenderManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

?>

<?php require_once __DIR__ . '/../../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/atributos/genero/">Géneros</a></p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Géneros</h1>
        </div>

        <div class="content-description">
            <p>Los géneros permiten diferenciar al público al que va dirigido el producto: no solo se refiere a hombre - mujer, también puede haber un género como, por ejemplo: 'Mascotas'. </p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/colores" >Colores</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/tallas/">Tallas</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/atributos/genero/" class="active-item">Géneros</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-atributos" data-form="genero">

                <div class="form-group" data-required="true" data-type="text">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-input" name="nombre" maxlength="50" autocomplete="off">

                    <p class="input-error-info">El nombre no puede estar vacío.</p>

                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/50</span>
                    </div>
                </div>

                <div class="form-submit">
                    <button class="form-submit-btn" type="submit">Añadir genero</button>
                </div>

            </form>

        </div>

        <!--datos de los atributos-->

        <div class="content-data">

            <?php 
                $genero = new GenderManager();

                echo '<h2 class="content-data-title">Géneros ('. $genero -> getGenderLength() .')</h2>';
            ?>

            <div class="table-container">
            <table class="table-element table-atributes">
                <thead class="table-header">
                    <tr>
                        <th class='centered'>
                            Id
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th class="centered">Editar</th>
                    </tr>
                </thead>

                <tbody class="table-body">

                    <?php
                    $resultado = $genero -> getAllGenders();

                    for ($i = 0; $i < $resultado -> num_rows; $i++) {
                        $fila = $resultado -> fetch_assoc();
                        
                        echo "<tr>
                            <td class='centered'>" . $fila['id'] . "</td>
                            <td>" . $fila['nombre'] . "</td>
                            <td class='centered'>
                                <button class='table-btn-edit'>
                                    <a href='http://localhost/urban/backoffice/catalogo/atributos/genero/editar.php?id=" . $fila['id'] . "'>
                                        <i class='bi bi-pencil-square'></i>
                                    </a>
                                </button>
                            </td>
                        </tr>";
                    }

                    ?>

                </tbody>
            </table>
            </div>

        </div>

        <!--fin datos de los atributos-->

    </div>
</div>

</div> <!--Final del container principal-->


<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/atributos/genero.js"; ?>"></script>

<?php require_once __DIR__ . '/../../../footer.php'; ?>