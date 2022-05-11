<?php

require_once __DIR__ . '/../../../security/controlAccess.php';
include_once __DIR__. '/../../../model/managers/CategoryManager.php';

$controlAccess = new ControlAccess();
if ($controlAccess->getUser() == null) {
    header("Location: /urban/backoffice/login.php");
    exit;
}

if($_SESSION['user']['permiso'] == '3') {
    header("Location: /urban/backoffice/catalogo/categorias/subcategorias/index.php");
    exit;
}

?>

<?php require_once __DIR__ . '/../../../head.php'; ?>

<div class="content-page">
    <div class="content-container">

        <div class="content-breadcrumb-box">
            <div class="breadcrumbs">
                <p><a href="http://localhost/urban/backoffice/">Dashboard</a> / <a href="http://localhost/urban/backoffice/catalogo/categorias/">Categorías</a> / <a href="http://localhost/urban/backoffice/catalogo/categorias/subcategorias/">Subcategorías</a> / Añadir subcategoría</p>
            </div>
        </div>

        <div class="content-header">
            <h1 class="content-title">Añadir subcategoría</h1>
        </div>

        <div class="content-description">
            <p>No te olvides de incluir una descripción adecuada, ya que se mostrará en la página web. Las subcategorías están directamente ligadas con los productos.</p>
        </div>

        <div class="content-menu">
            <div class="content-menu-box">
                <ul>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/subcategorias/">Overview</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/">Categorías</a></li>
                    <li><a href="http://localhost/urban/backoffice/catalogo/categorias/subcategorias/nueva.php" class="active-item"><i class="bi bi-plus"></i> Añadir subcategoría</a></li>
                </ul>
            </div>
        </div>

        <!-- Aquí empieza el contenido dinámico de la zona de administración -->
        <div class="form-container">

            <div class="form-message" id="form-message">
                <p class="form-message-text" id="form-message-text">Operación realizada con éxito</p>
                <button class="form-message-close"><i class="bi bi-x-lg"></i></button>
            </div>

            <form class="form-element" id="form-category">

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
                    <textarea type="descripcion" class="form-input" name="descripcion" maxlength="250" rows="4"></textarea>
                    <div class="form-group-info">
                        <span>Los caracteres especiales como {};/<> serán transformados por seguridad.</span>
                        <span class="input-length-counter">0/250</span>
                    </div>
                </div>

                <p class="form-label">Estado</p>
                <div class="form-status-area">
                    <div id="status" class="form-status-selector" data-availability="available">
                        <div class="form-status-ball"></div>
                    </div>
                    <input id="status-checkbox" type="checkbox" name="estado" class="form-status-checkbox" checked value="yes">
                    <span id="status-info" class="form-admin-status-info">Activo</span>
                    <p class="status-no-available">La categoría padre esta inactiva. Solo podrás activar la subcategoría activando la categoría padre.</p>
                </div>

                <div class="form-group" data-required="true" data-type="select">
                    <label for="categoria" class="form-label">Categoria padre *</label>
                    <select class="form-select" name="id_categoria" id="id_categoria">
                        <option value="" selected disabled>-- Seleccionar categoría --</option>
                        <?php
                            $categoryManager = new CategoryManager();

                            $categorias = $categoryManager -> getAllCategoryIdAndName();

                            for($i=0; $i < $categorias -> num_rows; $i++) {
                                $fila = $categorias->fetch_assoc();
                                echo "<option data-status='".$fila['estado']."' value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }

                        ?>
                    </select>
                    <p class="input-error-info">Debes realizar una selección.</p>
                </div>

                <div class="form-submit">
                    <button class="form-cancel-btn"><a href="http://localhost/urban/backoffice/catalogo/categorias/subcategorias">Cancelar</a></button>
                    <button class="form-submit-btn" type="submit">Añadir subcategoría</button>
                </div>

            </form>

        </div>

    </div>
</div>

</div> <!--Final del container principal-->

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/helpers/handleStatusInput.js"; ?>"></script>
<script type="module" src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . "/urban/backoffice/js/subcategorias/subcategorias.js"; ?>"></script>

<?php require_once __DIR__ . '/../../../footer.php'; ?>